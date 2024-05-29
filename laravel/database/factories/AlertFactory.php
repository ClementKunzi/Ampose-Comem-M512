<?php

namespace Database\Factories;

use App\Models\Alert;
use App\Models\User;
use App\Models\Itinerary;
use App\Enums\TypeAlertEnum;
use App\Enums\DescriptionAlertEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlertFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Alert::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //'type' => $this->faker->randomElement(TypeAlertEnum::toArray()),
            //'description' => $this->faker->randomElement(DescriptionAlertEnum::toArray()),
            'type' => $this->faker->word,
            'description' => $this->faker->sentence,
            'reporting_time' => $this->faker->dateTime(),
            'itinerary_id' => Itinerary::factory(),
            'user_id' => User::factory(),
        ];
    }
}
