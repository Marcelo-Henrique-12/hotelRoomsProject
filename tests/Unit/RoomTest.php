<?php

namespace Tests\Unit;

use App\Models\Room;
use App\Models\Hotel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoomTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_room()
    {
        $hotel = Hotel::factory()->create();

        $roomData = [
            'name' => 'Sample Room',
            'description' => 'This is a sample room description.',
            'hotel_id' => $hotel->id,
        ];

        Room::create($roomData);

        $this->assertDatabaseHas('rooms', $roomData);
    }

    public function test_can_read_room()
    {
        $this->withoutMiddleware();
        $room = Room::factory()->create();

        $response = $this->get(route('rooms.show', $room->id));

        $response->assertStatus(200);
    }

    public function test_can_update_room()
    {
        $hotel = Hotel::factory()->create();
        $room = Room::factory()->create();

        $updatedData = [
            'name' => 'Updated Room Name',
            'description' => 'Updated room description.',
            'hotel_id' => $hotel->id,
        ];

        $room->update($updatedData);
        $this->assertDatabaseHas('rooms', $updatedData);
    }

    public function test_can_delete_room()
    {
        $hotel = Hotel::factory()->create();
        $room = Room::factory()->create();


        $room->delete();
        $this->assertDatabaseMissing('rooms', ['id' => $room->id]);
    }
}
