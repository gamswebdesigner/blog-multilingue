<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostTranslationFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence(rand(3, 7));

        return [
            'locale' => 'de',
            'title' => $title,
            'body' => fake()->paragraphs(3, true),
        ];
    }
}
