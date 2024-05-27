<?php

namespace Database\Factories;

use App\Models\Itinerary;
use App\Models\Step;
use Illuminate\Database\Eloquent\Factories\Factory;

class StepFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Step::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'adress' => $this->faker->address,
            'schedule' => $this->faker->time($format = 'H:i:s', $max = 'now'),
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'order' => $this->faker->randomDigitNotNull,
            'external_link' => $this->faker->url,
            'itinerary_id' => Itinerary::factory(),
        ];
    }
}
