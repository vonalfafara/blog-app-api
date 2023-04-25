<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $datetime = fake()->date() . ' ' . fake()->time();
        return [
            'user_id' => fake()->randomElement(User::pluck('id')),
            'title' => fake()->realText($maxNbChars= 30),
            'subtitle' => fake()->realText($maxNbChars = 100),
            'body' => fake()->realText($maxNbChars = 4000),
            'created_at' => $datetime,
            'updated_at' => $datetime,
            'image' => '1682405997.jpg'
        ];
    }
}
