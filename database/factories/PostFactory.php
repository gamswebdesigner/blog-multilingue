<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence(rand(3, 7));

        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'slug' => Str::slug($title) . '-' . Str::random(5),
            'is_published' => true,
            'published_at' => now()->subDays(rand(1, 30)),
        ];
    }
}
