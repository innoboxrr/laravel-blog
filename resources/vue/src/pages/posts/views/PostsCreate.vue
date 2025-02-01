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
                    <post-actions-dropdown 
                        @actionSelected="dropdownActionSelected"
                    />
                </div>
            </div>
        </header>

        <main class="py-8">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Left: Form Container -->
                <div class="lg:col-span-2 bg-white border sm:rounded-lg">
                    <div class="px-6 py-8 sm:p-10">
                        <h2 class="text-lg font-semibold text-gray-700 border-b pb-4 mb-6">
                            {{ __blog('Post Details') }}
                        </h2>
                        <blog-post-create-form 
                            v-if="createAction === 'normalPost'"
                            :blog-id="blog.id"
                            :external-params="externalParams"
                            :preload-post="preloadPost"
                            @change="onChange"
                            @submit="onSubmit" />
                        <translate-with-ai-form 
                            v-else-if="createAction === 'translateWithAI'"
                            :blog-id="blog.id"
                            :external-params="externalParams"
                            @change="onChange"
                            @submit="setPreloadPost" />
                        <generate-with-ai-form
                            v-else-if="createAction === 'generateWithAI'"
                            :blog-id="blog.id"
                            :external-params="externalParams"
                            @change="onChange"
                            @submit="setPreloadPost" />
                        <transcript-with-ai-form
                            v-else-if="createAction === 'transcriptWithAI'"
                            :blog-id="blog.id"
                            :external-params="externalParams"
                            @change="onChange"
                            @submit="setPreloadPost" />
                        <video-to-text-ai-form
                            v-else-if="createAction === 'videoToTextAI'"
                            :blog-id="blog.id"
                            :external-params="externalParams"
                            @change="onChange"
                            @submit="setPreloadPost" />
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
                                <CategorySelector 
                                    :blog="blog"
                                    :preselectedCategories="preselectedCategories"
                                    @onChangeCategories="categorySelectorChange" />
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
                                <TagSelector 
                                    :preselectedTags="preselectedTags"
                                    @onChangeTags="tagsChange" />
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
                                {{ __blog('Upload a featured image.') }}
                            </p>
                            <!-- Placeholder for featured image -->
                            <div class="mt-4 border-t pt-4">
                                <FeaturedImage 
                                    :preview-image="null"
                                    @onFeaturedImageChange="featuredImageChange" />
                            </div>
                        </div>
                    </div>

                </aside>
            </div>
        </main>
    </div>
</template>

<script>
    import { toRefs } from 'vue';
    import { useGlobalStore } from '@blogStore/globalStore'; 
    
    import BlogPostCreateForm from '@blogModels/blog-post/forms/CreateForm.vue';
    import GenerateWithAiForm from '@blogModels/blog-post/forms/GenerateWithAiForm.vue';
    import TranscriptWithAiForm from '@blogModels/blog-post/forms/TranscriptWithAiForm.vue';
    import TranslateWithAiForm from '@blogModels/blog-post/forms/TranslateWithAiForm.vue';
    import VideoToTextAiForm from '@blogModels/blog-post/forms/VideoToTextAiForm.vue';

    import PostActionsDropdown from '../components/PostActionsDropdown.vue'; // Dropdown como componente aparte
    import CategorySelector from '@blogModels/blog-category/components/category-selector/CategorySelector.vue';
    import TagSelector from '@blogModels/blog-tag/components/tag-selector/TagSelector.vue';
    import FeaturedImage from '@blogModels/blog-post/components/featured-image/FeaturedImage.vue';

    export default {
        name: 'PostsCreate',
        components: {
            BlogPostCreateForm,
            GenerateWithAiForm,
            TranscriptWithAiForm,
            TranslateWithAiForm,
            VideoToTextAiForm,

            PostActionsDropdown,
            CategorySelector,
            TagSelector,
            FeaturedImage,
        },
        setup() {
            const globalStore = useGlobalStore();
            const { blog } = toRefs(globalStore);
            return {
                blog,
            };
        },
        data() {
            return {
                title: '',
                externalParams: {},
                preloadPost: {},
                preselectedCategories: [],
                preselectedTags: [],
                createAction: 'normalPost',
            };
        },
        methods: {
            onChange(data) {
                this.title = data.title;
            },
            categorySelectorChange(data) {
                const categoriesIds = data.map((category) => category.id);
                this.externalParams = {
                    ...this.externalParams,
                    categories: categoriesIds,
                };
            },
            tagsChange(data) {
                this.externalParams = {
                    ...this.externalParams,
                    tags: data,
                };
            },
            featuredImageChange(data) {
                this.externalParams = {
                    ...this.externalParams,
                    featured_image: data,
                };
            },
            onSubmit(data) {
                
            },
            setPreloadPost(data) {
                this.preloadPost = data;
                this.preloadPost.status = 'draft';
                console.log(this.preloadPost);
                this.dropdownActionSelected('normalPost');
            },
            dropdownActionSelected(action) {
                this.createAction = action;
            },
        },
    };
</script>
