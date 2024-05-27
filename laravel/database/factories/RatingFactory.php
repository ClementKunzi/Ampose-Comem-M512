<?php

namespace Database\Factories;

use App\Models\Rating;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Itinerary;

class RatingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rating::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'note' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->sentence,
            'user_id' => User::factory(),
            'itinerary_id' => Itinerary::factory(),
        ];
    }
}
