<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\City;
use App\Models\Role;
use App\Models\User;
use App\Models\Facility;
use App\Models\Property;
use App\Models\Apartment;
use App\Models\FacilityCategory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApartmentShowTest extends TestCase
{
    
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_apartment_show_loads_apartment_with_facilities()
    {
        $owner = User::factory()->create()->assignRole(Role::ROLE_OWNER);
        $cityId = City::value('id');
        $property = Property::factory()->create([
            'owner_id' => $owner->id,
            'city_id' => $cityId,
        ]);
        $apartment = Apartment::factory()->create([
            'name' => 'Large apartment',
            'property_id' => $property->id,
            'capacity_adults' => 3,
            'capacity_children' => 2,
        ]);
 
        $firstCategory = FacilityCategory::create([
            'name' => 'First category'
        ]);
        $secondCategory = FacilityCategory::create([
            'name' => 'Second category'
        ]);
        $firstFacility = Facility::create([
            'category_id' => $firstCategory->id,
            'name' => 'First facility'
        ]);
        $secondFacility = Facility::create([
            'category_id' => $firstCategory->id,
            'name' => 'Second facility'
        ]);
        $thirdFacility = Facility::create([
            'category_id' => $secondCategory->id,
            'name' => 'Third facility'
        ]);
        $apartment->facilities()->attach([
            $firstFacility->id, $secondFacility->id, $thirdFacility->id
        ]);
 
        $response = $this->getJson('/api/apartments/'.$apartment->id);
        $response->assertStatus(200);
        $response->assertJsonPath('name', $apartment->name);
        $response->assertJsonCount(2, 'facility_categories');
        //  Error occured in this part 9 

 
        $expectedFacilityArray = [
            $firstCategory->name => [
                $firstFacility->name,
                $secondFacility->name
            ],
            $secondCategory->name => [
                $thirdFacility->name
            ]
        ];

        $response->assertJsonFragment($expectedFacilityArray, 'facility_categories');
        
    }
}
