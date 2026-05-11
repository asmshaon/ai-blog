<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BlogPostFactory extends Factory
{
    protected $model = \App\Models\BlogPost::class;

    public function definition(): array
    {
        $title = fake()->sentence();

        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => fake()->paragraph(),
            'content' => fake()->paragraphs(5, true),
            'featured_image' => null,
            'seo_title' => null,
            'seo_description' => null,
            'seo_keywords' => null,
            'canonical_url' => null,
            'og_image' => null,
            'featured' => false,
            'view_count' => 0,
            'status' => 'published',
            'published_at' => now()->subDay(),
            'reading_time' => fake()->numberBetween(1, 10),
        ];
    }
}
