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
                        <article class="prose max-w-none" v-html="blogPost.content"></article>

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
                        <div class="mt-12">
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
                    <div class="bg-white border rounded-md p-6">
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
                            <p>
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
