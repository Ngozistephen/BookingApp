<?php

namespace App\Http\Controllers\Public;

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
                'apartments.rooms.beds.bed_type'
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
            ->get();

            return PropertySearchResource::collection($properties);
    }
}
