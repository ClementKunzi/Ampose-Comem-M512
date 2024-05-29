<?php

namespace Database\Seeders;

// database/seeders/ItinerariesTableSeeder.php
use App\Models\Itinerary;
use Illuminate\Database\Seeder;

class ItinerariesTableSeeder extends Seeder
{
    public function run()
    {
        Itinerary::factory()->count(50)->create();
    }
}
