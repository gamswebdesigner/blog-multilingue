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

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
