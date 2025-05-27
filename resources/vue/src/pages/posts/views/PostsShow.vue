<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <header class="sticky top-0 z-10 bg-white border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between py-6">
                    <h1 class="text-3xl font-extrabold text-gray-900">
                        {{ blogPost.title || __blog('Detalle de la publicación') }}
                    </h1>
                    <!-- Puedes incluir botones o un dropdown de acciones aquí -->
                </div>
            </div>
        </header>

        <!-- Main content -->
        <main class="py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Contenido Principal -->
                <div class="lg:col-span-2 bg-white border rounded-md">
                    <div class="px-6 py-8">

                        <!-- Imagen Destacada -->
                        <div
                            v-if="blogPost.payload && blogPost.payload.images && blogPost.payload.images.original"
                            class="mb-8">
                            <img
                                :src="blogPost.payload.images.original"
                                alt="Imagen Destacada"
                                class="w-full rounded-md" />
                        </div>

                        <!-- Información Meta -->
                        <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between">
                            <div class="text-gray-600 text-sm">
                                <span>{{ __blog('Publicado el') }} {{ formattedDate }}</span>
                                <span v-if="blogPost.categories && blogPost.categories.length" class="ml-2">
                                    | {{ __blog('Categorías:') }}
                                    <span v-for="(category, index) in blogPost.categories" :key="category.id">
                                        {{ category.name }}<span v-if="index < blogPost.categories.length - 1">, </span>
                                    </span>
                                </span>
                            </div>
                            <div class="flex space-x-4 text-sm text-gray-600 mt-2 sm:mt-0">
                                <div>
                                    <span class="font-medium">{{ blogPost.payload.stats.views || 0 }}</span>
                                    {{ __blog('Vistas') }}
                                </div>
                                <div>
                                    <span class="font-medium">{{ blogPost.payload.stats.likes || 0 }}</span>
                                    {{ __blog('Likes') }}
                                </div>
                                <div>
                                    <span class="font-medium">{{ blogPost.payload.stats.comments || 0 }}</span>
                                    {{ __blog('Comentarios') }}
                                </div>
                            </div>
                        </div>

                        <!-- Contenido de la Publicación -->
                        <article 
                            class="blog-post-article-text" 
                            v-html="blogPost.content"></article>

                        <!-- Metadatos Adicionales -->
                        <div v-if="blogPost.payload && blogPost.payload.metas" class="mt-10">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">{{ __blog('Metadatos') }}</h3>
                            <div class="text-gray-700 text-sm">
                                <p>
                                    <strong>{{ __blog('Keywords') }}:</strong>
                                    {{ keywords || '-' }}
                                </p>
                                <p>
                                    <strong>{{ __blog('Descripción') }}:</strong>
                                    {{ blogPost.payload.metas.description || '-' }}
                                </p>
                            </div>
                        </div>

                        <!-- Sección de Comentarios -->
                        <div v-if="false" class="mt-12">
                            <h3 class="text-2xl font-semibold text-gray-800 mb-6">{{ __blog('Comentarios') }}</h3>
                            <div v-if="comments && comments.length" class="space-y-6">
                                <div
                                    v-for="comment in comments"
                                    :key="comment.id"
                                    class="border-t pt-6">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm text-gray-800 font-medium">{{ comment.author }}</p>
                                        <p class="text-sm text-gray-500">{{ comment.date }}</p>
                                    </div>
                                    <p class="mt-2 text-gray-700">{{ comment.content }}</p>
                                </div>
                            </div>
                            <div v-else class="text-gray-600 text-sm">
                                {{ __blog('No hay comentarios') }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Sidebar Widgets -->
                <aside class="space-y-8">
                    <!-- Widget de Compartir -->
                    <div v-if="false" class="bg-white border rounded-md p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __blog('Compartir') }}</h3>
                        <div class="flex flex-col space-y-3">
                            <button class="flex items-center space-x-2 text-blue-600 hover:underline">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22.46 6c-.77.35-1.6.58-2.46.69a4.26 4.26 0 001.88-2.35 8.49 8.49 0 01-2.7 1.03 4.23 4.23 0 00-7.2 3.86A12 12 0 013 4.79a4.23 4.23 0 001.31 5.65 4.21 4.21 0 01-1.91-.53v.05a4.24 4.24 0 003.39 4.15 4.3 4.3 0 01-1.9.07 4.24 4.24 0 003.96 2.95A8.48 8.48 0 012 19.54 12 12 0 008.29 21c7.55 0 11.68-6.26 11.68-11.68 0-.18-.01-.35-.02-.53A8.34 8.34 0 0024 6.59a8.32 8.32 0 01-2.54.7z"/>
                                </svg>
                                <span>
                                    {{ __blog('Twitter') }} ({{ blogPost.payload.share_buttons.twitter || 0 }})
                                </span>
                            </button>
                            <button class="flex items-center space-x-2 text-blue-700 hover:underline">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22 12a10 10 0 10-11.5 9.95v-7.05h-2.9V12h2.9v-2.2c0-2.86 1.7-4.43 4.3-4.43 1.25 0 2.56.22 2.56.22v2.82h-1.44c-1.42 0-1.86.88-1.86 1.78V12h3.16l-.5 2.9h-2.66v7.05A10 10 0 0022 12z"/>
                                </svg>
                                <span>
                                    {{ __blog('Facebook') }} ({{ blogPost.payload.share_buttons.facebook || 0 }})
                                </span>
                            </button>
                            <button class="flex items-center space-x-2 text-blue-500 hover:underline">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 0h-14a5 5 0 00-5 5v14a5 5 0 005 5h14a5 5 0 005-5v-14a5 5 0 00-5-5zm-11 19h-3v-9h3zm-1.5-10.3a1.74 1.74 0 111.74-1.74 1.74 1.74 0 01-1.74 1.74zm13.5 10.3h-3v-4.8c0-1.15-.02-2.63-1.6-2.63s-1.84 1.25-1.84 2.54v4.89h-3v-9h2.88v1.23h.04a3.16 3.16 0 012.85-1.56c3.04 0 3.6 2 3.6 4.6z"/>
                                </svg>
                                <span>
                                    {{ __blog('LinkedIn') }} ({{ blogPost.payload.share_buttons.linkedin || 0 }})
                                </span>
                            </button>
                        </div>
                    </div>

                    <!-- Widget de Estadísticas -->
                    <div class="bg-white border rounded-md p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __blog('Estadísticas') }}</h3>
                        <div class="space-y-2 text-sm text-gray-700">
                            <p>
                                {{ __blog('Comentarios totales') }}:
                                <span class="font-medium">{{ blogPost.payload.stats.comments || 0 }}</span>
                            </p>
                            <p>
                                {{ __blog('Vistas totales') }}:
                                <span class="font-medium">{{ blogPost.payload.stats.views || 0 }}</span>
                            </p>
                            <p v-if="false">
                                {{ __blog('Likes totales') }}:
                                <span class="font-medium">{{ blogPost.payload.stats.likes || 0 }}</span>
                            </p>
                        </div>
                    </div>
                </aside>
            </div>
        </main>
    </div>
</template>

<script>
    import dayjs from 'dayjs'
    import { showModel } from '@blogModels/blog-post'

    export default {
        name: 'BlogPostShow',
        data() {
            return {
                blogPost: {
                    title: '',
                    content: '',
                    categories: [],
                    published_at: '',
                    payload: {
                        metas: {},
                        stats: {},
                        images: {},
                        share_buttons: {}
                    }
                },
                keywords: undefined,
                comments: [],
                loading: true
            }
        },
        computed: {
            formattedDate() {
                return this.blogPost.published_at
                    ? dayjs(this.blogPost.published_at).format('MMMM D, YYYY')
                    : ''
            },
            formattedPayload() {
                return JSON.stringify(this.blogPost.payload, null, 2)
            }
        },
        async created() {
            const postId = this.$route.params.id
            try {
                const res = await showModel(postId, ['tags', 'categories'])
                this.blogPost = res
                if (!this.blogPost.published_at) {
                    this.blogPost.published_at = new Date().toISOString()
                }
                // Simulación de comentarios (puedes reemplazarlo con una llamada a tu API)
                this.comments = [
                    /*
                    {
                        id: 1,
                        author: 'Usuario 1',
                        date: dayjs().subtract(2, 'day').format('MMMM D, YYYY'),
                        content: 'Excelente publicación.'
                    },
                    {
                        id: 2,
                        author: 'Usuario 2',
                        date: dayjs().subtract(1, 'day').format('MMMM D, YYYY'),
                        content: 'Muy informativo, gracias!'
                    }
                    */
                ];

                this.keywords = this.blogPost.tags.map((tag) => tag.name).join(',')
            } catch (error) {
                console.error('Error al obtener la publicación:', error)
            } finally {
                this.loading = false
            }
        }
    }
</script>

<style>
.blog-post-article-text * {
    all: unset !important;
    display: revert !important;
    box-sizing: border-box !important;
    margin: 0 !important;
    padding: 0 !important;
}

/* Elementos base */
.blog-post-article-text {
    font-size: 1rem !important;
    line-height: 1.8 !important;
    color: #1f2937 !important;
    font-family: 'Inter', sans-serif !important;
}

/* Títulos */
.blog-post-article-text h1,
.blog-post-article-text h2,
.blog-post-article-text h3,
.blog-post-article-text h4,
.blog-post-article-text h5,
.blog-post-article-text h6 {
    font-weight: 700 !important;
    margin-top: 2rem !important;
    margin-bottom: 1rem !important;
    color: #111827 !important;
}

.blog-post-article-text h1 { font-size: 2rem !important; }
.blog-post-article-text h2 { font-size: 1.75rem !important; }
.blog-post-article-text h3 { font-size: 1.5rem !important; }
.blog-post-article-text h4 { font-size: 1.25rem !important; }
.blog-post-article-text h5 { font-size: 1.125rem !important; }
.blog-post-article-text h6 { font-size: 1rem !important; }

/* Párrafos y span */
.blog-post-article-text p {
    margin: 1.25rem 0 !important;
}

.blog-post-article-text span {
    font-style: italic !important;
    color: #4b5563 !important;
}

/* Listas */
.blog-post-article-text ul,
.blog-post-article-text ol {
    margin-left: 1.5rem !important;
    margin-bottom: 1.5rem !important;
    padding-left: 1rem !important;
}

.blog-post-article-text ul li {
    list-style-type: disc !important;
    margin-bottom: 0.5rem !important;
}

.blog-post-article-text ol li {
    list-style-type: decimal !important;
    margin-bottom: 0.5rem !important;
}

/* Blockquote */
.blog-post-article-text blockquote {
    margin: 1.5rem 0 !important;
    padding: 1rem 1.5rem !important;
    border-left: 4px solid #3b82f6 !important;
    background-color: #f9fafb !important;
    color: #374151 !important;
    font-style: italic !important;
}

/* Tablas */
.blog-post-article-text table {
    width: 100% !important;
    margin: 2rem 0 !important;
    border-collapse: collapse !important;
    border: 1px solid #d1d5db !important;
}

.blog-post-article-text thead {
    background-color: #f3f4f6 !important;
    font-weight: bold !important;
}

.blog-post-article-text tbody tr:nth-child(odd) {
    background-color: #f9fafb !important;
}

.blog-post-article-text th,
.blog-post-article-text td {
    border: 1px solid #d1d5db !important;
    padding: 0.75rem 1rem !important;
    text-align: left !important;
}

.blog-post-article-text th {
    background-color: #e5e7eb !important;
}

/* Enlaces */
.blog-post-article-text a {
    color: #2563eb !important;
    text-decoration: underline !important;
    transition: color 0.2s ease !important;
}

.blog-post-article-text a:hover {
    color: #1d4ed8 !important;
}

/* Multimedia */
.blog-post-article-text img {
    max-width: 100% !important;
    height: auto !important;
    border-radius: 0.5rem !important;
    margin: 1.5rem 0 !important;
    display: block !important;
}

.blog-post-article-text video,
.blog-post-article-text iframe {
    max-width: 100% !important;
    margin: 1.5rem 0 !important;
    border-radius: 0.5rem !important;
    display: block !important;
}

.blog-post-article-text iframe {
    border: none !important;
    aspect-ratio: 16 / 9 !important;
    height: auto !important;
}

/* Código */
.blog-post-article-text code {
    background-color: #f3f4f6 !important;
    color: #dc2626 !important;
    padding: 0.2rem 0.4rem !important;
    border-radius: 0.25rem !important;
    font-family: 'Fira Code', monospace !important;
    font-size: 0.95em !important;
}

.blog-post-article-text pre {
    background-color: #1e293b !important;
    color: #f8fafc !important;
    padding: 1rem !important;
    border-radius: 0.5rem !important;
    overflow-x: auto !important;
    font-family: 'Fira Code', monospace !important;
    font-size: 0.95em !important;
    margin: 1.5rem 0 !important;
}

/* Otros */
.blog-post-article-text strong {
    font-weight: bold !important;
    color: #111827 !important;
}

.blog-post-article-text em {
    font-style: italic !important;
    color: #4b5563 !important;
}

.blog-post-article-text hr {
    border: none !important;
    border-top: 1px solid #e5e7eb !important;
    margin: 2rem 0 !important;
}

.blog-post-article-text figure {
    margin: 2rem 0 !important;
    text-align: center !important;
}

.blog-post-article-text figcaption {
    font-size: 0.875rem !important;
    color: #6b7280 !important;
    margin-top: 0.5rem !important;
}

.blog-post-article-text mark {
    background-color: #fef08a !important;
    padding: 0.1rem 0.25rem !important;
    border-radius: 0.25rem !important;
    font-weight: bold !important;
}

.blog-post-article-text abbr[title] {
    text-decoration: underline dotted !important;
    cursor: help !important;
}

.blog-post-article-text del {
    text-decoration: line-through !important;
    color: #9ca3af !important;
}

.blog-post-article-text ins {
    text-decoration: underline !important;
    color: #16a34a !important;
}

.blog-post-article-text small {
    font-size: 0.875rem !important;
    color: #6b7280 !important;
}

.blog-post-article-text iframe,
.blog-post-article-text video,
.blog-post-article-text embed,
.blog-post-article-text object {
    display: block !important;
    width: 100% !important;
    max-width: 100% !important;
    margin: 1.5rem 0 !important;
    border-radius: 0.5rem !important;
    aspect-ratio: 16 / 9 !important;
    border: none !important;
}

.blog-post-article-text .responsive-embed {
    position: relative !important;
    padding-bottom: 56.25% !important; /* 16:9 ratio */
    height: 0 !important;
    overflow: hidden !important;
    margin: 1.5rem 0 !important;
}

.blog-post-article-text .responsive-embed iframe {
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    width: 100% !important;
    height: 100% !important;
    border: none !important;
}


</style>