<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    // Model de Room
    protected $model = Room::class;

    // Definição dos dados a serem gerados
    public function definition(): array
    {
        return [
            'hotel_id' => Hotel::exists() ? Hotel::inRandomOrder()->first()->id : Hotel::factory(),
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
        ];
    }
}
