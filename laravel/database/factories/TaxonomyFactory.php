<?php

namespace Database\Factories;

use App\Models\Taxonomy;
use App\Enums\NameTaxonomyEnum;
use App\Enums\DescriptionTaxonomyEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaxonomyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Taxonomy::class;

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
            'icon' => $this->faker->imageUrl(50, 50),
        ];
    }
}
