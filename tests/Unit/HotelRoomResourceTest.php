<?php

namespace Tests\Feature;

use App\Models\Hotel;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HotelRoomResourceTest extends TestCase
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
        $hotelData = Hotel::factory()->make()->toArray();

        $response = $this->actingAs($user)
                         ->post(route('hotels.store'), $hotelData);

        $response->assertStatus(302);
    }

    public function test_can_update_hotel()
    {
        $user = User::factory()->create();
        $hotel = Hotel::factory()->create();
        $updatedData = ['name' => 'Updated Hotel Name'];

        $response = $this->actingAs($user)
                         ->put(route('hotels.update', $hotel->id), $updatedData);

        $response->assertStatus(302);
    }

    public function test_can_delete_hotel()
    {
        $user = User::factory()->create();
        $hotel = Hotel::factory()->create();

        $response = $this->actingAs($user)
                         ->delete(route('hotels.destroy', $hotel->id));

        $response->assertStatus(302);
    }

    public function test_can_list_rooms()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
                         ->get(route('rooms.index'));

        $response->assertStatus(200);
    }

    public function test_can_create_room()
    {
        $user = User::factory()->create();
        $roomData = Room::factory()->make()->toArray();

        $response = $this->actingAs($user)
                         ->post(route('rooms.store'), $roomData);

        $response->assertStatus(302);
    }

    public function test_can_update_room()
    {
        $user = User::factory()->create();
        $room = Room::factory()->create();
        $updatedData = ['name' => 'Updated Room Name'];

        $response = $this->actingAs($user)
                         ->put(route('rooms.update', $room->id), $updatedData);

        $response->assertStatus(302);
    }

    public function test_can_delete_room()
    {
        $user = User::factory()->create();
        $room = Room::factory()->create();

        $response = $this->actingAs($user)
                         ->delete(route('rooms.destroy', $room->id));

        $response->assertStatus(302);
    }


}

