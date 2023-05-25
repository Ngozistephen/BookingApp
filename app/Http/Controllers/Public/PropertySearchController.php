<?php

namespace App\Http\Controllers\Public;

use App\Models\Property;
use App\Models\Geoobject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PropertySearchController extends Controller
{
    public function __invoke(Request $request)
    {
        return Property::with('city')
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
            ->get();
    }
}
