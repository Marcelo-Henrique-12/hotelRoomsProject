<?php

namespace Tests\Unit;

use App\Models\Hotel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HotelTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_hotel()
    {
        $this->withoutMiddleware(); //ignora o middleware de autenticação

        // Dados do hotel a ser criado
        $hotelData = [
            'name' => 'Hotel Test',
            'address' => '123 Main Street',
            'city' => 'Sample City',
            'state' => 'ST',
            'zip_code' => '12345',
            'website' => 'http://hoteltest.com',
        ];

        Hotel::create($hotelData);

        // Verificar se os dados foram armazenados corretamente no banco de dados
        $this->assertDatabaseHas('hotels', $hotelData);
    }

    public function test_can_read_hotel()
    {
        $this->withoutMiddleware();

        $hotel = Hotel::factory()->create();

        $response = $this->get(route('hotels.show', $hotel->id));

        $response->assertStatus(200);
    }

    public function test_can_update_hotel()
    {
        $this->withoutMiddleware();
        $hotel = Hotel::factory()->create();

        $updatedData = [
            'name' => 'Updated Hotel Name',
            'address' => $hotel->address,
            'city' => $hotel->city,
            'state' => $hotel->state,
            'zip_code' => $hotel->zip_code,
            'website' => $hotel->website,
        ];

        $hotel = Hotel::findOrFail($hotel->id);
        $hotel->update($updatedData);

        $this->assertDatabaseHas('hotels', $updatedData);
    }


    public function test_can_delete_hotel()
    {
        $hotel = Hotel::factory()->create();
        $hotel->delete();
        $this->assertDatabaseMissing('hotels', ['id' => $hotel->id]);
    }

}
