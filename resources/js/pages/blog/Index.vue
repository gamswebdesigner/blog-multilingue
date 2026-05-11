<script setup lang="ts">
interface Post {
    id: number
    published_at: string
    category: { name: string } | null
    translation: { title: string; body: string } | null
}

defineProps < {
    posts: Post[]
  locale: string
} > ()
</script>

<template>
    <main style="max-width: 800px; margin: 60px auto; padding: 0 20px; font-family: system-ui, sans-serif;">
        <h1 style="font-size: 2rem; margin-bottom: 30px; color: #1a1a1a;">
            {{ locale === 'de' ? 'Neueste Beiträge' : 'Latest Posts' }}
        </h1>

        <div v-if="posts.length === 0" style="color: #666;">
            {{ locale === 'de' ? 'Keine Beiträge vorhanden.' : 'No posts yet.' }}
        </div>

        <article v-for="post in posts" :key="post.id"
            style="background: #fff; border-radius: 8px; padding: 24px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            <h2 style="font-size: 1.4rem; margin: 0 0 8px; color: #1a1a1a;">
                {{ post.translation?.title }}
            </h2>
            <p style="font-size: 0.85rem; color: #888; margin: 0 0 12px;">
                {{ new Date(post.published_at).toLocaleDateString('de-DE') }} — {{ post.category?.name }}
            </p>
            <p style="color: #444; line-height: 1.6;">
                {{ post.translation?.body?.substring(0, 200) }}...
            </p>
        </article>
    </main>
</template>
