<?php

namespace App\Http\Controllers\Public;

use App\Models\Facility;
use App\Models\Property;
use App\Models\Geoobject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PropertySearchResource;

class PropertySearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $properties = Property::query()->with
            ([
                // add rooms,bed and bed types to search
                'city',
                'apartments.apartment_type',
                'apartments.rooms.beds.bed_type',
                // for prices
                'apartments.prices' => function($query) use ($request) {
                    $query->validForRange([
                        $request->start_date ?? now()->addDay()->toDateString(),
                        $request->end_date ?? now()->addDays(2)->toDateString(),
                    ]);
                },
                'facilities',
                'media' => fn($query) => $query->orderBy('position'),
            ])
            ->when($request->city, function($query) use ($request){
                $query->where('city_id', $request->city);
            })
            // search by country
            ->when($request->country, function($query) use ($request) {
                $query->whereHas('city', fn($q) => $q->where('country_id', $request->country));
            })

            // search by GeoObject
            ->when($request->geoobject, function($query) use ($request) {
                $geoobject = Geoobject::find($request->geoobject);
                if ($geoobject) {
                    $condition = "(
                        6371 * acos(
                            cos(radians(" . $geoobject->lat . "))
                            * cos(radians(`lat`))
                            * cos(radians(`long`) - radians(" . $geoobject->long . "))
                            + sin(radians(" . $geoobject->lat . ")) * sin(radians(`lat`))
                        ) < 10
                    )";
                    $query->whereRaw($condition);
                }
            })

            // by children and Adults
            ->when($request->adults && $request->children, function($query) use ($request) {
                $query->withWhereHas('apartments', function($query) use ($request) {
                    $query->where('capacity_adults', '>=', $request->adults)
                        ->where('capacity_children', '>=', $request->children)
                        ->orderBy('capacity_adults') 
                        ->orderBy('capacity_children')
                        ->take(1);
                });
            })

            // filter by facilities
            ->when($request->facilities, function($query) use ($request) {
                $query->whereHas('facilities', function($query) use ($request) {
                    $query->whereIn('facilities.id', $request->facilities);
                });
            })

            // filter by Prices
            ->when($request->price_from, function($query) use ($request) {
                $query->whereHas('apartments.prices', function($query) use ($request) {
                    $query->where('price', '>=', $request->price_from);
                });
            })
            ->when($request->price_to, function($query) use ($request) {
                $query->whereHas('apartments.prices', function($query) use ($request) {
                    $query->where('price', '<=', $request->price_to);
                });
            })
            ->get();

            $facilities = Facility::query()
                ->withCount(['properties' => function ($property) use ($properties) {
                    $property->whereIn('id', $properties->pluck('id'));
                }])
                ->get()
                ->where('properties_count', '>', 0)
                ->sortByDesc('properties_count')
                ->pluck('properties_count', 'name');

            return [
                
                PropertySearchResource::collection($properties),
                'facilities' => $facilities,
            ];
    }
}
