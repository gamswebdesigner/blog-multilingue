<script setup lang="ts">
interface Post {
    id: number
    slug: string
    published_at: string
    category: { name: string; slug: string } | null
    translation: { title: string; body: string } | null
}

interface Category {
    slug: string
    name: string
}

defineProps<{
    posts: {
        data: Post[]
        links: {
            url: string | null
            label: string
            active: boolean
        }[]
    }
    locale: string
    currentCategory?: Category | null  // ← o "?" torna opcional
}>()

function formatDate(date: string): string {
    return new Date(date).toLocaleDateString('de-DE')
}
</script>

<template>
    <main style="max-width: 800px; margin: 60px auto; padding: 0 20px; font-family: system-ui, sans-serif;">
        <h1 style="font-size: 2rem; margin-bottom: 10px; color: #1a1a1a;">
            {{ currentCategory?.name ?? (locale === 'de' ? 'Alle Beiträge' : 'All Posts') }}
        </h1>

        <p v-if="currentCategory" style="color: #666; margin-bottom: 30px;">
            <a href="/" style="color: #2563eb; text-decoration: none;">
                ← {{ locale === 'de' ? 'Alle Kategorien' : 'All categories' }}
            </a>
        </p>

        <div v-if="posts.data.length === 0" style="color: #666;">
            {{ locale === 'de' ? 'Keine Beiträge in dieser Kategorie.' : 'No posts in this category.' }}
        </div>

        <article v-for="post in posts.data" :key="post.id"
            style="background: #fff; border-radius: 8px; padding: 24px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            <h2 style="font-size: 1.4rem; margin: 0 0 8px; color: #1a1a1a;">
                <a :href="`/post/${post.slug}`" style="color: inherit; text-decoration: none;">
                    {{ post.translation?.title }}
                </a>
            </h2>
            <p style="font-size: 0.85rem; color: #888; margin: 0 0 12px;">
                {{ formatDate(post.published_at) }} — {{ post.category?.name }}
            </p>
            <p style="color: #444; line-height: 1.6;">
                {{ post.translation?.body?.substring(0, 200) }}...
            </p>
        </article>

        <!-- Pagination -->
        <nav v-if="posts.links.length > 3" style="display: flex; gap: 8px; justify-content: center; margin-top: 30px;">
            <template v-for="link in posts.links" :key="link.label">
                <a v-if="link.url" :href="link.url" :style="{
                    padding: '8px 14px',
                    borderRadius: '6px',
                    textDecoration: 'none',
                    background: link.active ? '#2563eb' : '#f3f4f6',
                    color: link.active ? '#fff' : '#374151',
                    fontWeight: link.active ? 'bold' : 'normal',
                }" v-html="link.label" />
                <span v-else style="padding: 8px 14px; color: #9ca3af;" v-html="link.label" />
            </template>
        </nav>
    </main>
</template>
