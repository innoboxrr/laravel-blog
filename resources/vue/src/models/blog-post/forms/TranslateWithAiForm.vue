<template>
    <div>
        <!-- Encabezado -->
        <div class="rounded-md bg-blue-50 p-4 mb-6">
            <div class="flex">
                <div class="shrink-0">
                    <svg class="size-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3 flex-1 md:flex md:justify-between">
                    <p class="text-sm text-blue-700">
                        {{ __blog('Translate Content with AI') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <div v-if="!loading">
            <textarea-input-component
                :label="__blog('Original Text')"
                name="text"
                :rows="10"
                :custom-class="inputClass"
                validators="required"
                v-model="params.text"
            />

            <select-input-component
                :label="__blog('From Language')"
                name="sourceLanguage"
                :custom-class="inputClass"
                v-model="params.sourceLanguage">
                <option value="auto">{{ __blog('Detect Language Automatically') }}</option>
                <option v-for="(label, key) in languages" :key="key" :value="key">
                    {{ label }}
                </option>
            </select-input-component>

            <select-input-component
                :label="__blog('To Language')"
                name="targetLanguage"
                :custom-class="inputClass"
                validators="required"
                v-model="params.targetLanguage">
                <option v-for="(label, key) in languages" :key="key" :value="key">
                    {{ label }}
                </option>
            </select-input-component>

            <select-input-component
                :label="__blog('Improve with AI')"
                name="rewrite"
                :custom-class="inputClass"
                v-model="params.rewrite">
                <option :value="true">{{ __blog('Yes') }}</option>
                <option :value="false">{{ __blog('No') }}</option>
            </select-input-component>

            <button-component
                :value="__blog('Translate')"
                :custom-class="buttonClass"
                @click="translateContent"
            />
        </div>

        <div v-if="loading" class="mt-4 flex flex-col items-center space-y-2">
            <div class="animate-spin rounded-full h-10 w-10 border-t-4 border-blue-500 border-solid"></div>
            <p class="text-blue-500 font-medium text-center">{{ __blog('Translating content...') }}</p>
        </div>

        <div v-if="result" class="mt-6">
            <text-input-component
                :label="__blog('Title')"
                name="title"
                :custom-class="inputClass"
                validators="required"
                v-model="title"
            />

            <editor-input-component
                class="mt-4"
                id="translated-content"
                :file="false"
                name="content"
                :height="500"
                :label="__blog('Translated Content')"
                validators="required"
                v-model="content"
            />

            <button-component
                @click="submit"
                :custom-class="buttonClass"
                :value="__blog('Continue')"
            />
        </div>
    </div>
</template>

<script>
import { slugify } from 'innoboxrr-js-libs/libs/string';
import { makeHttpRequest } from 'innoboxrr-http-request';
import {
    TextInputComponent,
    TextareaInputComponent,
    EditorInputComponent,
    SelectInputComponent,
    ButtonComponent,
} from 'innoboxrr-form-elements';

export default {
    components: {
        TextInputComponent,
        TextareaInputComponent,
        EditorInputComponent,
        SelectInputComponent,
        ButtonComponent,
    },
    props: {
        blogId: {
            type: [String, Number],
            required: true,
        },
    },
    emits: ['submit'],
    data() {
        return {
            params: {
                text: '',
                sourceLanguage: 'auto',
                targetLanguage: 'en',
                rewrite: true,
            },
            languages: {
                en: 'English',
                es: 'Spanish',
                fr: 'French',
                de: 'German',
                it: 'Italian',
                ch: 'Chinese',
                ja: 'Japanese',
                ko: 'Korean',
                ru: 'Russian',
            },
            loading: false,
            result: null,
            title: '',
            content: '',
        };
    },
    methods: {
        async translateContent() {
            this.loading = true;
            this.result = null;
            try {
                const { finalText } = await makeHttpRequest('POST', route('api.larablog.blog.lambda'), {
                    blog_id: this.blogId,
                    action: 'translateWithAI',
                    payload: {
                        text: this.params.text,
                        sourceLanguage: this.params.sourceLanguage,
                        targetLanguage: this.params.targetLanguage,
                        rewrite: this.params.rewrite,
                    },
                });
                this.content = finalText;
                this.title = this.content.substring(0, 50) + '...';
                this.result = { content: finalText };
            } catch (error) {
                console.error('Translation error:', error);
            } finally {
                this.loading = false;
            }
        },
        submit() {
            this.$emit('submit', {
                title: this.title,
                slug: slugify(this.title),
                content: this.content,
            });
        },
    },
};
</script>

<style scoped>
.prose {
    max-width: 100%;
}
</style>
