<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostTranslation;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user for the panel
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@blog.de',
            'password' => bcrypt('password'),
        ]);

        // Categories
        $categories = [
            ['slug' => 'webentwicklung', 'name_de' => 'Webentwicklung', 'name_en' => 'Web Development'],
            ['slug' => 'devops', 'name_de' => 'DevOps', 'name_en' => 'DevOps'],
            ['slug' => 'karriere', 'name_de' => 'Karriere', 'name_en' => 'Career'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Posts with translations
        Category::all()->each(function ($category) {
            Post::factory(3)->create([
                'user_id' => 1,
                'category_id' => $category->id,
            ])->each(function ($post) {
                PostTranslation::factory()->create([
                    'post_id' => $post->id,
                    'locale' => 'de',
                ]);
                PostTranslation::factory()->create([
                    'post_id' => $post->id,
                    'locale' => 'en',
                ]);
            });
        });
    }
}
