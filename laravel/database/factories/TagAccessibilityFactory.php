<?php

namespace Database\Factories;

use App\Models\TagAccessibility;
use App\Models\Taxonomy;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagAccessibilityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TagAccessibility::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'taxonomy_id' => Taxonomy::factory(),
        ];
    }
}
