<?php

namespace Database\Seeders;

use App\Models\Geoobject;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GeoobjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Geoobject::create([
            'city_id' => 1,
            'name' => 'Eko Atlantic',
            'lat' => 6.4105,
            'long' => 3.4158
        ]);
 
        Geoobject::create([
            'city_id' => 2,
            'name' => 'cape coast',
            'lat' => 5.1315,
            'long' => 1.2795
        ]);
        Geoobject::create([
            'city_id' => 3,
            'name' => 'Statue of Liberty',
            'lat' => 40.689247,
            'long' => -74.044502
        ]);
 
        Geoobject::create([
            'city_id' => 4,
            'name' => 'Big Ben',
            'lat' => 51.500729,
            'long' => -0.124625
        ]);
        Geoobject::create([
            'city_id' => 5,
            'name' => 'Gugong Bowuyuan',
            'lat' => 39.9163,
            'long' => 116.3972
        ]);
    }
}
