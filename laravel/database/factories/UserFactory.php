<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'username' => $this->faker->userName,
            'last_name' => $this->faker->lastName,
            'first_name' => $this->faker->firstName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'), // password
            'email_verification' => $this->faker->boolean,
            'email_verified_at' => $this->faker->dateTime(),
            'last_login' => $this->faker->dateTime(),
            'number_path_added' => $this->faker->randomNumber(),
            'profile_picture' => $this->faker->imageUrl(),
        ];
    }
}
