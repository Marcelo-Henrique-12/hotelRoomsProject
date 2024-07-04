<?php

namespace Tests\Unit;

use App\Models\Hotel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HotelTest extends TestCase
{
    use RefreshDatabase;


    public function test_can_list_hotels()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->get(route('hotels.index'));

        $response->assertStatus(200);
    }

    public function test_can_create_hotel()
    {
        $user = User::factory()->create();
        $hotelData = [
            'name' => 'Hotel Test',
            'address' => '123 Main Street',
            'city' => 'Sample City',
            'state' => 'ST',
            'zip_code' => '12345678',
            'website' => 'http://hoteltest.com',
        ];

        $response = $this->actingAs($user)->post(route('hotels.store'), $hotelData);
        $response->assertStatus(302);
        $this->assertDatabaseHas('hotels', $hotelData);
    }

    public function test_can_read_hotel()
    {
        $user = User::factory()->create();

        $hotel = Hotel::factory()->create();

        $response =  $this->actingAs($user)->get(route('hotels.show', $hotel->id));

        $response->assertStatus(200);
    }

    public function test_can_update_hotel()
    {
        $user = User::factory()->create();
        $hotelData = [
            'name' => 'Hotel Test',
            'address' => '123 Main Street',
            'city' => 'Sample City',
            'state' => 'ST',
            'zip_code' => '12345678',
            'website' => 'http://hoteltest.com',
        ];

        $hotel = Hotel::create($hotelData);


        $updatedData = [
            'name' => 'Update Hotel Test',
            'address' => 'Update 123 Main Street',
            'city' => 'Sample City',
            'state' => 'ST',
            'zip_code' => '12345678',
            'website' => 'http://hoteltest.com',
        ];

        $response = $this->actingAs($user)
        ->put(route('hotels.update', $hotel->id), $updatedData);


        $response->assertStatus(302);

        $this->assertDatabaseHas('hotels', $updatedData);
    }


    public function test_can_delete_hotel()
    {
        $user = User::factory()->create();
        $hotel = Hotel::factory()->create();

        $response = $this->actingAs($user)
            ->delete(route('hotels.destroy', $hotel->id));

        $response->assertStatus(302);
        $this->assertDatabaseMissing('hotels', ['id' => $hotel->id]);
    }
}
