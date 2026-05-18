<script setup lang="ts">
interface Post {
    slug: string
    published_at: string
    is_published: boolean
    category: { name: string; slug: string } | null
    translation: { title: string; body: string } | null
}

defineProps<{
    post: Post
    locale: string
}>()
</script>

<template>
    <main style="max-width: 750px; margin: 60px auto; padding: 0 20px; font-family: system-ui, sans-serif;">
        <a :href="route('blog.index')"
            style="color: #2563eb; text-decoration: none; font-size: 0.9rem; display: inline-block; margin-bottom: 30px;">
            ← {{ locale === 'de' ? 'Zurück zur Übersicht' : 'Back to overview' }}
        </a>

        <article>
            <h1 style="font-size: 2.2rem; margin: 0 0 10px; color: #1a1a1a;">
                {{ post.translation?.title }}
            </h1>
            <p style="font-size: 0.9rem; color: #888; margin: 0 0 30px;">
                {{ new Date(post.published_at).toLocaleDateString('de-DE') }}
                —
                <a :href="route('blog.category', { post: post.category?.slug })"
                    style="color: #2563eb; text-decoration: none;">
                    {{ post.category?.name }}
                </a>
            </p>
            <div style="color: #444; line-height: 1.8; font-size: 1.05rem;">
                {{ post.translation?.body }}
            </div>
        </article>
    </main>
</template>
