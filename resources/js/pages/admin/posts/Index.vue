<script setup lang="ts">
interface Post {
    id: number
    slug: string
    is_published: boolean
    created_at: string
    category: { name: string } | null
    translation: { title: string } | null
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
}>()
</script>

<template>
    <main style="max-width: 1000px; margin: 40px auto; padding: 0 20px; font-family: system-ui, sans-serif;">
        <h1 style="font-size: 1.8rem; margin-bottom: 24px; color: #1a1a1a;">Posts</h1>

        <table
            style="width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            <thead>
                <tr style="border-bottom: 2px solid #e5e7eb; text-align: left;">
                    <th style="padding: 12px 16px; color: #6b7280; font-size: 0.85rem;">Title</th>
                    <th style="padding: 12px 16px; color: #6b7280; font-size: 0.85rem;">Category</th>
                    <th style="padding: 12px 16px; color: #6b7280; font-size: 0.85rem;">Status</th>
                    <th style="padding: 12px 16px; color: #6b7280; font-size: 0.85rem;">Date</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="post in posts.data" :key="post.id" style="border-bottom: 1px solid #f3f4f6;">
                    <td style="padding: 12px 16px;">{{ post.translation?.title }}</td>
                    <td style="padding: 12px 16px;">{{ post.category?.name }}</td>
                    <td style="padding: 12px 16px;">
                        <span :style="{
                            padding: '2px 10px',
                            borderRadius: '12px',
                            fontSize: '0.8rem',
                            background: post.is_published ? '#dcfce7' : '#fef3c7',
                            color: post.is_published ? '#166534' : '#92400e',
                        }">
                            {{ post.is_published ? 'Published' : 'Draft' }}
                        </span>
                    </td>
                    <td style="padding: 12px 16px; color: #6b7280; font-size: 0.9rem;">
                        {{ new Date(post.created_at).toLocaleDateString('de-DE') }}
                    </td>
                </tr>
            </tbody>
        </table>
    </main>
</template>
