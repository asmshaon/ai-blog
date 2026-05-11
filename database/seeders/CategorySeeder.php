<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Artificial Intelligence', 'slug' => 'artificial-intelligence', 'description' => 'AI research, techniques, and applications.'],
            ['name' => 'Large Language Models', 'slug' => 'large-language-models', 'description' => 'LLMs, transformers, and NLP breakthroughs.'],
            ['name' => 'System Design', 'slug' => 'system-design', 'description' => 'Designing scalable and reliable systems.'],
            ['name' => 'Software Architecture', 'slug' => 'software-architecture', 'description' => 'Architectural patterns and best practices.'],
            ['name' => 'Machine Learning', 'slug' => 'machine-learning', 'description' => 'ML algorithms, training, and deployment.'],
            ['name' => 'MLOps', 'slug' => 'mlops', 'description' => 'Operationalizing machine learning at scale.'],
            ['name' => 'Deep Learning', 'slug' => 'deep-learning', 'description' => 'Neural networks and deep learning advances.'],
            ['name' => 'Cloud Computing', 'slug' => 'cloud-computing', 'description' => 'Cloud-native architectures and services.'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
