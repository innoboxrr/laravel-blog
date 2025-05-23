<template>
    <form :id="formId" @submit.prevent="onSubmit">
        <text-input-component
            :label="__blog('Title')"
            type="text"
            name="title"
            :required="true"
            validators="required"
            :custom-class="inputClass"
            v-model="blogPost.title" />

        <div>
            <label for="slug" class="block text-sm/6 font-medium text-gray-900">
                {{ __blog('Friendly URL') }}
            </label>
            <div class="mt-2 flex">
                <div class="flex shrink-0 items-center rounded-l-md bg-gray-100 px-3 text-base text-gray-500 outline outline-1 -outline-offset-1 outline-gray-300 sm:text-sm/6">
                    https://my-blog.com/
                </div>
                <input 
                    type="text" 
                    name="slug" 
                    id="slug" 
                    validators="required alphanumeric_dash"
                    :class="inputClassWithUrl"
                    v-model="blogPost.slug"
                    data-validators="alphanumeric"
                    placeholder="custom-code" />
            </div>
        </div>

        <editor-input-component
            :id="`content-${formId}`"
            :file="true"
            :uploadUrl="fileUploadUrl"
            :onFileUploadSuccess="handleFileUploadSuccess"
            name="content"
            :height="500"
            :label="__blog('Content')"
            :placeholder="__blog('Content')"
            validators="required"
            v-model="blogPost.content" />

        <select-input-component
            :label="__blog('Status')"
            name="status"
            :required="true"
            validators="required"
            :custom-class="inputClass"
            v-model="blogPost.status">
            <option value="draft">{{ __blog('Draft') }}</option>
            <option value="published">{{ __blog('Published') }}</option>
            <option value="archived">{{ __blog('Archived') }}</option>
        </select-input-component>

        <text-input-component
            :label="__blog('Publish date')"
            type="datetime-local"
            name="publish_at"
            :required="true"
            validators="required"
            :custom-class="inputClass"
            v-model="blogPost.publish_at" />

        <youtube-playlist
            v-if="blogPost.payload && blogPost.payload.playlist"
            v-model="blogPost.payload.playlist" />

        <button-component
            :custom-class="buttonClass"
            :disabled="disabled"
            :value="__blog('Actualizar')" />
    </form>
</template>

<script>
    import dayjs from 'dayjs'; 
    import { showModel, updateModel } from '@blogModels/blog-post'
    import JSValidator from 'innoboxrr-js-validator'
    import { slugify } from 'innoboxrr-js-libs/libs/string'
    import YoutubePlaylist from '../components/YoutubePlaylist.vue'
    import {
        TextInputComponent,
        EditorInputComponent,
        SelectInputComponent,
        ButtonComponent,
    } from 'innoboxrr-form-elements'

    export default {
        components: {
            YoutubePlaylist,
            TextInputComponent,
            EditorInputComponent,
            SelectInputComponent,
            ButtonComponent,
        },

        props: {
            formId: {
                type: String,
                default: 'editBlogPostForm'
            },
            blogPostId: {
                type: [Number, String],
                required: true
            },
            preloadPost: {
                type: Object,
                default: () => ({
                    title: '',
                    slug: '',
                    status: 'draft',
                    content: '',
                    published_at: '',
                    payload: {
                        playlist: [],
                    }
                }),
            },
        },

        emits: ['submit', 'blogPostLoaded'],

        data() {
            return {
                blogPost: {
                    title: '',
                    slug: '',
                    content: '',
                    status: 'draft',
                    publish_at: '',
                    payload: {
                        playlist: [],
                    }
                },
                disabled: false,
                JSValidator: undefined,
            }
        },

        computed: {
            validForm() {
                return this.JSValidator ? this.JSValidator.status : false;
            },
        },

        watch: {
            'blogPost.title': {
                handler(newTitle) {
                    this.blogPost.slug = slugify(newTitle);
                }
            },
            preloadPost: {
                handler(newPost) {
                    console.log('Preload post changed:', newPost);
                    this.blogPost = {
                        ...this.blogPost,
                        ...newPost
                    };
                },
                deep: true,
            },
        },

        mounted() {
            this.fetchData();
            this.JSValidator = new JSValidator(this.formId).init();
            this.JSValidator.status = true;
        },

        methods: {
            async fetchData() {
                await this.fetchBlogPost();
            },
            async fetchBlogPost() {
                try {
                    const res = await showModel(this.blogPostId, [
                        'tags',
                        'categories'
                    ]);
                    if (res.published_at) {
                        res.published_at = dayjs(res.published_at).format('YYYY-MM-DDTHH:mm');
                    } else {
                        res.published_at = dayjs(new Date()).format('YYYY-MM-DDTHH:mm');
                    }
                    this.blogPost = res;

                    this.blogPost = {...this.blogPost, ...this.preloadPost };

                    // Ver si existe playlist y ver si es sctring convertir en JSON
                    if (this.blogPost.payload && this.blogPost.payload.playlist) {
                        if (typeof this.blogPost.payload.playlist === 'string') {
                            try {
                                this.blogPost.payload.playlist = JSON.parse(this.blogPost.payload.playlist);
                            } catch (e) {
                                console.error("Error al parsear la playlist:", e);
                            }
                        }
                    } else {
                        this.blogPost.payload.playlist = [];
                    }

                    this.$emit('blogPostLoaded', this.blogPost);
                } catch (error) {
                    console.error("Error al cargar el blog post:", error);
                }
            },
            async onSubmit() {
                if (this.JSValidator.status) {
                    this.disabled = true;
                    try {
                        const res = await updateModel(this.blogPost.id, {
                            ...this.blogPost, ...this.blogPost.payload 
                        });
                        this.$emit('submit', res);
                        setTimeout(() => {
                            this.disabled = false;
                        }, 2500);
                    } catch (error) {
                        this.disabled = false;
                        if (error.response && error.response.status === 422) {
                            this.JSValidator.appendExternalErrors(error.response.data.errors);
                        }
                    }
                } else {
                    this.disabled = false;
                }
            }
        }
    }
</script>
