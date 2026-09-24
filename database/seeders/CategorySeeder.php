<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Backend', 'slug' => 'backend', 'description' => 'APIs, data models and the business rules behind them.'],
            ['name' => 'Payments', 'slug' => 'payments', 'description' => 'Pricing, money movement and payment providers.'],
            ['name' => 'System Design', 'slug' => 'system-design', 'description' => 'Integrations, data pipelines and designing for failure.'],
            ['name' => 'Laravel', 'slug' => 'laravel', 'description' => 'Practical Laravel from production systems.'],
            ['name' => 'Security', 'slug' => 'security', 'description' => 'Security reviews, fixes and hardening.'],
            ['name' => 'DevOps', 'slug' => 'devops', 'description' => 'Deploys, queues, monitoring and keeping systems running.'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
