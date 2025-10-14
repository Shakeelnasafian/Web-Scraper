<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'source' => fake()->company(),
            'title' => fake()->sentence(),
            'url' => fake()->url(),
            'description' => fake()->paragraph(),
            'content' => fake()->paragraphs(3, true),
            'url_to_image' => fake()->imageUrl(),
            'published_at' => fake()->dateTime(),
            'category' => fake()->randomElement(['Technology', 'Business', 'Sports', 'Entertainment', 'Health']),
        ];
    }
}
