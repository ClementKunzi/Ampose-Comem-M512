<?php

namespace Database\Factories;

use App\Models\Itinerary;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\SourceEnum;
use App\Enums\TypeItineraryEnum;

class ItineraryFactory extends Factory
{
    protected $model = Itinerary::class;

    public function definition()
    {

        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence,
            'user_id' => \App\Models\User::factory(),
            'length' => $this->faker->randomFloat(2, 1, 100),
            'positive_drop' => $this->faker->randomFloat(2, 1, 100),
            'negative_drop' => $this->faker->randomFloat(2, 1, 100),
            'estimated_time' => $this->faker->randomFloat(2, 1, 100),
            'difficulty' => $this->faker->randomFloat(2, 1, 5),
            'source' => $this->faker->word,
            'type' => $this->faker->word,
            'image_id' => \App\Models\Image::factory(),
            'pdf_url' => $this->faker->url,
        ];
    }
}
