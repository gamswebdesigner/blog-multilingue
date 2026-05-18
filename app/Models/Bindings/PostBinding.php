<?php

namespace App\Models\Bindings;

use App\Models\Post;
use Illuminate\Routing\Route;

class PostBinding
{
    public static function resolve(Route $route): Post
    {
        return Post::where('slug', $route->parameter('post'))
            ->where('is_published', true)
            ->firstOrFail();
    }
}
