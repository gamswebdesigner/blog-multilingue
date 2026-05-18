<?php

use App\Models\Post;
use App\Http\Controllers\Admin\PostController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Category;
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

Route::get('/post/{post:slug}', function (Post $post) {
    if (! $post->is_published) {
        abort(404);
    }

    return Inertia::render('blog/Show', [
        'post' => $post->load(['category', 'translation']),
        'locale' => app()->getLocale(),
    ]);
})->name('blog.show');

Route::get('/category/{category:slug?}', function (?Category $category) {
    $posts = Post::where('is_published', true)
        ->with(['category', 'translation'])
        ->when($category, function ($query) use ($category) {
            return $query->where('category_id', $category->id);
        })
        ->orderBy('published_at', 'desc')
        ->paginate(6);

    return Inertia::render('blog/Index', [
        'posts' => $posts,
        'locale' => app()->getLocale(),
        'currentCategory' => $category,
    ]);
})->name('blog.category');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    // edit, create, store, update, destroy virão depois
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
