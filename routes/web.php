<?php

use App\Models\Post;
use App\Http\Controllers\Admin\PostController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Bindings\PostBinding;

Route::get('/', function () {
    $posts = Post::where('is_published', true)
        ->with(['category', 'translation'])
        ->orderBy('published_at', 'desc')
        ->paginate(6);

    return Inertia::render('blog/Index', [
        'posts' => $posts,
        'locale' => app()->getLocale(),
        'currentCategory' => null,
    ]);
})->name('blog.index');

Route::get('/post/{post}', function (Post $post) {
    return Inertia::render('blog/Show', [
        'post' => $post->load(['category', 'translation']),
        'locale' => app()->getLocale(),
    ]);
})->name('blog.show');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    // edit, create, store, update, destroy virão depois
});

// Explicit route model binding
Route::bind('post', [PostBinding::class, 'resolve']);

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
