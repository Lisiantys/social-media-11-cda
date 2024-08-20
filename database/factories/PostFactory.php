<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => $this->faker->paragraph(),
            'user_id' => rand(1, User::count()),
            'tags' => $this->faker->words(3, true),
            'image' => 'images/tree.jpg', // Utilisé comme image de base pour la factory
        ];
    }
}
