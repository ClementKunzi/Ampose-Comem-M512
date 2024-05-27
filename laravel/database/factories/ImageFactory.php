<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition()
    {
        return [
            'url' => $this->faker->imageUrl(),
            'alt_attr' => $this->faker->sentence,
        ];
    }
}
