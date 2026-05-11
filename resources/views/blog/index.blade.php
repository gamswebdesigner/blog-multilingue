<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Multilingue</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <main class="max-w-4xl mx-auto py-12 px-4">
        <h1 class="text-4xl font-bold mb-10 text-gray-900">
            {{ app()->getLocale() === 'de' ? 'Neueste Beiträge' : 'Latest Posts' }}
        </h1>

        @if ($posts->isEmpty())
            <p class="text-gray-500">
                {{ app()->getLocale() === 'de' ? 'Keine Beiträge vorhanden.' : 'No posts yet.' }}
            </p>
        @else
            <div class="grid gap-8">
                @foreach ($posts as $post)
                    <article class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-2">
                            {{ $post->translation()?->title }}
                        </h2>
                        <p class="text-sm text-gray-500 mb-4">
                            {{ $post->published_at->format('d.m.Y') }} — {{ $post->category->name }}
                        </p>
                        <p class="text-gray-700">
                            {{ Str::limit(strip_tags($post->translation()?->body ?? ''), 200) }}
                        </p>
                    </article>
                @endforeach
            </div>
        @endif
    </main>
</body>

</html>
