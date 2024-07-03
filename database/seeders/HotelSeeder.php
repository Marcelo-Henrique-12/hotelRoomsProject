<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $hotels= 5; //Defina a quantidade de quartos a serem gerados, irá pegar os hoteis gerados também
        Hotel::factory()->count($hotels)->create();
    }
}
