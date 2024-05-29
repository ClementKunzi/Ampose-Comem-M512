<?php

namespace Database\Factories;

use App\Models\TagCategorie;
use App\Models\Taxonomy;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagCategorieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TagCategorie::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'taxonomy_id' => Taxonomy::factory(),
            'color' => $this->faker->safeColorName,
        ];
    }
}
