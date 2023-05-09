<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingsTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_user_has_access_to_bookings_feature()
    {
        // $owner = User::factory()->create(['role_id' => Role::ROLE_USER]);
        $user = User::factory()->create()->assignRole(Role::ROLE_USER);
        $response = $this->actingAs($user)->getJson('/api/user/bookings');
 
        $response->assertStatus(200);
    }
 
    public function test_property_owner_does_not_have_access_to_bookings_feature()
    {
        // $owner = User::factory()->create(['role_id' => Role::ROLE_OWNER]);
        $owner = User::factory()->create()->assignRole(Role::ROLE_OWNER);
        $response = $this->actingAs($owner)->getJson('/api/user/bookings');
 
        $response->assertStatus(403);
    }
}
