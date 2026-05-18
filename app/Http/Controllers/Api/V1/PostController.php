<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * List published posts.
     *
     * Query params:
     * - category: filter by category slug
     * - locale: filter by locale (default: app locale)
     */
    public function index(Request $request): JsonResponse
    {
        $locale = $request->query('locale', app()->getLocale());

        $posts = Post::where('is_published', true)
            ->with(['category', 'translations'])
            ->when($request->query('category'), function ($query, $category) {
                return $query->whereHas('category', function ($q) use ($category) {
                    $q->where('slug', $category);
                });
            })
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        // Shape the response — include only the translation for the requested locale
        $posts->getCollection()->transform(function ($post) use ($locale) {
            $translation = $post->translations->firstWhere('locale', $locale);

            return [
                'id' => $post->id,
                'slug' => $post->slug,
                'title' => $translation?->title,
                'excerpt' => $translation ? substr(strip_tags($translation->body), 0, 200) : null,
                'category' => $post->category->name,
                'published_at' => $post->published_at->toISOString(),
                'url' => route('blog.show', $post->slug),
            ];
        });

        return response()->json($posts);
    }

    /**
     * Show a single post.
     */
    public function show(Request $request, Post $post): JsonResponse
    {
        if (! $post->is_published) {
            abort(404);
        }

        $locale = $request->query('locale', app()->getLocale());
        $translation = $post->translations->firstWhere('locale', $locale);

        return response()->json([
            'id' => $post->id,
            'slug' => $post->slug,
            'title' => $translation?->title,
            'body' => $translation?->body,
            'category' => $post->category->name,
            'published_at' => $post->published_at->toISOString(),
            'url' => route('blog.show', $post->slug),
        ]);
    }
}
