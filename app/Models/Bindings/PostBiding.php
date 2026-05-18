<?php

namespace App\Models\Bindings;

use App\Models\Post;
use Illuminate\Routing\Route;

class PostBinding
{
    /**
     * Resolve the Post model for route binding.
     * This is EXPLICIT binding — custom resolution logic.
     */
    public function resolve(Route $route): Post
    {
        return Post::where('slug', $route->parameter('post'))
            ->where('is_published', true)
            ->firstOrFail();
    }
}
