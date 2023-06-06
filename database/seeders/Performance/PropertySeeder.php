<?php

namespace Database\Seeders\Performance;

use App\Models\City;
use App\Models\Role;
use App\Models\User;
use App\Models\Property;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(int $count = 100): void
    {
        // $users = User::where('role_id', Role::ROLE_OWNER)->pluck('id');
        $users = User::role('ROLE_OWNER')->pluck('id'); 
        //  $users = Role::where('role_id', Role::ROLE_OWNER)->pluck('id'); my own 
        Role::all()->pluck('name');

        
        $cities = City::pluck('id');
 
        for ($i = 1; $i <= $count; $i++) {
            Property::factory()->create([
                'owner_id' => $users->random(),
                'city_id' => $cities->random(),
            ]);
        }
    }
}
