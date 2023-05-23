<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Country::create([
            'name' => 'Nigeria',
            'lat' => 9.0820,
            'long' => 8.6753
        ]);
        Country::create([
            'name' => 'Ghana',
            'lat' => 7.9465,
            'long' => 1.0232
        ]);
        Country::create([
            'name' => 'United States',
            'lat' => 37.09024,
            'long' => -95.712891
        ]);
        Country::create([
            'name' => 'United Kingdom',
            'lat' => 55.378051,
            'long' => -3.435973
        ]);
        Country::create([
            'name' => 'China',
            'lat' => 35.8617,
            'long' => 104.1954
        ]);


    }
}
