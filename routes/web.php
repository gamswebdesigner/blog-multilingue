<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    $posts = Post::where('is_published', true)
        ->with(['category', 'translation'])
        ->orderBy('published_at', 'desc')
        ->take(6)
        ->get();

    return Inertia::render('blog/Index', [
        'posts' => $posts,
        'locale' => app()->getLocale(),
    ]);
})->name('blog.index');

Route::get('/post/{post:slug}', function (Post $post) {
    if (! $post->is_published) {
        abort(404);
    }

    return Inertia::render('blog/Show', [
        'post' => $post->load(['category', 'translation']),
        'locale' => app()->getLocale(),
    ]);
})->name('blog.show');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
