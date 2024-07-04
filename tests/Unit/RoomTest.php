<?php

namespace Tests\Unit;

use App\Models\Room;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoomTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_rooms()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->get(route('rooms.index'));

        $response->assertStatus(200);
    }

    public function test_can_create_room()
    {
        $hotel = Hotel::factory()->create();
        $user = User::factory()->create();
        $roomData = [
            'name' => 'Sample Room',
            'description' => 'This is a sample room description.',
            'hotel_id' => $hotel->id,
        ];

        $response = $this->actingAs($user)
            ->post(route('rooms.store'), $roomData);

        $response->assertStatus(302);

        $this->assertDatabaseHas('rooms', $roomData);
    }

    public function test_can_read_room()
    {
        $user = User::factory()->create();
        $room = Room::factory()->create();

        $response = $this->actingAs($user)->get(route('rooms.show', $room->id));

        $response->assertStatus(200);
    }

    public function test_can_update_room()
    {
        $user = User::factory()->create();
        $hotel = Hotel::factory()->create();
        $room = Room::factory()->create();

        $updatedData = [
            'name' => 'Updated Room Name',
            'description' => 'Updated room description.',
            'hotel_id' => $hotel->id,
        ];

        $response = $this->actingAs($user)
        ->put(route('rooms.update', $room->id), $updatedData);
        $response->assertStatus(302);

        $this->assertDatabaseHas('rooms', $updatedData);
    }

    public function test_can_delete_room()
    {
        $user = User::factory()->create();
        $room = Room::factory()->create();

        $response = $this->actingAs($user)
            ->delete(route('rooms.destroy', $room->id));

        $response->assertStatus(302);
        $this->assertDatabaseMissing('rooms', ['id' => $room->id]);
    }
}
