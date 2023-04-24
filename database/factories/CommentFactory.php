<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Blog;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
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
            'blog_id' => fake()->randomElement(Blog::pluck('id')),
            'body' => fake()->realText($maxNbChars = 255),
            'created_at' => $datetime,
            'updated_at' => $datetime
        ];
    }
}
