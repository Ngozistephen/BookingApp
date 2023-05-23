<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        City::create([
            'country_id' => 1,
            'name' => 'Lagos',
            'lat' => 6.5244,
            'long' => 3.3792
        ]);
        City::create([
            'country_id' => 2,
            'name' => 'Accra',
            'lat' => 5.6037,
            'long' => 0.1870,
        ]);
        City::create([
            'country_id' => 3,
            'name' => 'New York',
            'lat' => 40.712776,
            'long' => -74.005974,
        ]);
 
        City::create([
            'country_id' => 4,
            'name' => 'London',
            'lat' => 51.507351,
            'long' => -0.127758,
        ]);
        City::create([
            'country_id' => 5,
            'name' => 'Beijing',
            'lat' => 39.9042,
            'long' => 116.4074,
        ]);
    }
}
