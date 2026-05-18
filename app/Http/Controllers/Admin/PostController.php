<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['category', 'translation'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return Inertia::render('admin/posts/Index', [
            'posts' => $posts,
        ]);
    }
}
