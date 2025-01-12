<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <header class="sticky top-0 z-10 bg-white border-b border">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between py-4">
                    <h1 class="text-xl font-bold text-gray-900">
                        {{ title !== '' ? title : __blog('Create Blog Post') }}
                    </h1>
                    <!-- Dropdown for actions -->
                    <PostActionsDropdown 
                        @generateWithAI="generateWithAI"
                        @importBlog="importBlog"
                        @cancelCreation="cancelCreation"
                        @previewPost="previewPost"
                    />
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="py-10">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left: Form Container -->
                <div class="lg:col-span-2 bg-white border sm:rounded-lg">
                    <div class="px-6 py-8 sm:p-10">
                        <h2 class="text-lg font-semibold text-gray-700 border-b pb-4 mb-6">
                            {{ __blog('Blog Details') }}
                        </h2>
                        <BlogPostCreateForm 
                            @change="onChange"
                            @submit="onSubmit" />
                    </div>
                </div>

                <!-- Right: Sidebar -->
                <aside class="space-y-6">
                    <!-- Categories Section -->
                    <div class="bg-white border sm:rounded-lg">
                        <div class="px-6 py-5 sm:p-6">
                            <h3 class="text-lg font-medium text-gray-900">
                                {{ __blog('Categories') }}
                            </h3>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __blog('Select categories for this post.') }}
                            </p>
                            <!-- Placeholder for categories -->
                            <div class="mt-4 border-t pt-4">
                                <p class="text-sm text-gray-400">
                                    {{ __blog('Categories selector component goes here') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Tags Section -->
                    <div class="bg-white border sm:rounded-lg">
                        <div class="px-6 py-5 sm:p-6">
                            <h3 class="text-lg font-medium text-gray-900">
                                {{ __blog('Tags') }}
                            </h3>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __blog('Add tags to improve discoverability.') }}
                            </p>
                            <!-- Placeholder for tags -->
                            <div class="mt-4 border-t pt-4">
                                <p class="text-sm text-gray-400">
                                    {{ __blog('Tags input component goes here') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Image Section -->
                    <div class="bg-white border sm:rounded-lg">
                        <div class="px-6 py-5 sm:p-6">
                            <h3 class="text-lg font-medium text-gray-900">
                                {{ __blog('Featured Image') }}
                            </h3>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __blog('Upload a featured image for this post.') }}
                            </p>
                            <!-- Placeholder for featured image -->
                            <div class="mt-4 border-t pt-4">
                                <p class="text-sm text-gray-400">
                                    {{ __blog('Image uploader component goes here') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </main>
    </div>
</template>

<script>
import BlogPostCreateForm from '@blogModels/blog-post/forms/CreateForm.vue';
import PostActionsDropdown from '../components/PostActionsDropdown.vue'; // Dropdown como componente aparte

export default {
    name: 'PostsCreate',
    components: {
        BlogPostCreateForm,
        PostActionsDropdown,
    },
    data() {
        return {
            title: '',
        };
    },
    methods: {
        onChange(data) {
            this.title = data.title;
        },
        onSubmit(result) {
            console.log('Blog post created:', result);
            // Redirigir o realizar otra acción después de crear el blog
        },
        generateWithAI() {
            console.log('Generate content with AI');
        },
        importBlog() {
            console.log('Importing blog...');
        },
        cancelCreation() {
            console.log('Cancel creation');
        },
        previewPost() {
            console.log('Previewing post');
        },
    },
};
</script>
