<template>
	<form :id="formId" @submit.prevent="onSubmit">      

        <text-input-component
            :label="__blog('Title')"
            type="text"
            name="title"
            :required="true"
            validators="required"
            :custom-class="inputClass"
            v-model="post.title" />

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
                    v-model="post.slug"
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
            v-model="post.content" />

        <select-input-component
            :label="__blog('Status')"
            name="status"
            :required="true"
            validators="required"
            :custom-class="inputClass"
            v-model="post.status">
            <option value="draft">{{ __blog('Draft') }}</option>
            <option value="published">{{ __blog('Published') }}</option>
            <option value="archived">{{ __blog('Archived') }}</option>
        </select-input-component>

        <text-input-component
            :label="__blog('Publish date')"
            type="datetime-local"
            name="published_at"
            :required="true"
            validators="required"
            :custom-class="inputClass"
            v-model="post.published_at" />

        <youtube-playlist
            v-if="post.payload && post.payload.playlist"
            v-model="post.payload.playlist" />

        <button-component
            :custom-class="buttonClass"
            :disabled="disabled && !validForm"
            :value="(disabled) ? __blog('...') : __blog('Crear publicación')" />
        
    </form>
</template>

<script>

    import dayjs from 'dayjs';
    import { slugify } from 'innoboxrr-js-libs/libs/string';
    import { createModel } from '@blogModels/blog-post'
    import JSValidator from 'innoboxrr-js-validator'
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
        		default: 'createBlogPostForm',
        	},
            blogId: {
                type: Number,
                required: true,
            },
            externalParams: {
                type: Object,
                default: () => ({}),
            },
            preloadPost: {
                type: Object,
                default: () => ({
                    title: '',
                    slug: '',
                    status: 'published',
                    content: '',
                    published_at: '',
                    payload: {
                        playlist: [],
                    }
                }),
            },
        },
        emits: ['submit', 'change'],
        data() {
            return {
                post: JSON.parse(JSON.stringify(this.preloadPost)),
                disabled: false,
                JSValidator: undefined,
            }
        },
        async mounted() {
            await this.fetchData();
            this.JSValidator = new JSValidator(this.formId).init();
        },
        watch: {
            post: {
                handler() {
                    this.$emit('change', this.post);
                },
                deep: true,
            },
            'post.title': {
                handler() {
                    this.post.slug = slugify(this.post.title, '-');
                }
            },
            'post.slug': {
                handler() {
                    this.post.slug = slugify(this.post.slug, '-');
                }
            },
        },
        computed: {
            validForm() {
                return this.JSValidator.status;
            },
            submitData() {
                return {
                    ...this.post,
                    ...this.externalParams,
                    ...this.post.payload,
                    blog_id: this.blogId,
                }
            },
        },
        methods: {

            fetchData() {
                this.post.published_at = dayjs().format('YYYY-MM-DDTHH:mm');
                this.post.status = 'published';
                if (!this.post.payload) {
                    this.post.payload = { playlist: [] }
                } else if (!this.post.payload.playlist) {
                    this.post.payload.playlist = []
                }
            },

            onSubmit() {
                if(this.JSValidator.status && !this.disabled) {
                    this.disabled = true;

                    createModel(this.submitData).then(res => {
                        this.$emit('submit', res);
                        setTimeout(() => { this.disabled = false; }, 2500);
                    }).catch(error => {
                        this.disabled = false;
                        if(error.response.status == 422)
                            this.JSValidator
                                .appendExternalErrors(error.response.data.errors);
                        this.alert('error', this.__blog('Error al crear la publicación'));
                    });
                } else {
                    this.disabled = false;
                }
            },
        }
	}
</script>