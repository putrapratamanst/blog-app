<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'slug' => $this->faker->slug,
            'meta_title' => $this->faker->sentence,
            'author' => $this->faker->numberBetween(1, 100), // Ubah sesuai dengan range ID penulis yang valid
            'content' => $this->faker->paragraphs(3, true),
            'image' => $this->faker->imageUrl(),
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'status' => $this->faker->randomElement(['published', 'draft', 'archived']),
            'category_id' => $this->faker->numberBetween(1, 10), // Ubah sesuai dengan range ID kategori yang valid
            'tag' => $this->faker->words(5, true),
        ];
    }
}
