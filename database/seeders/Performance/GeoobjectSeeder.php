<?php

namespace Database\Seeders\Performance;

use App\Models\Geoobject;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GeoobjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(int $count = 100): void
    {
        Geoobject::factory($count)->create();
    }
}
