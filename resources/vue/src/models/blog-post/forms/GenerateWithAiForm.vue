<template>
    <div>
        <!-- Encabezado -->
        <div class="rounded-md bg-blue-50 p-4 mb-6">
            <div class="flex">
                <div class="shrink-0">
                    <svg class="size-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3 flex-1 md:flex md:justify-between">
                    <p class="text-sm text-blue-700">
                        {{ __blog('Generate Content with AI') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <div v-if="!loading" :id="formId">
            <!-- Input para el prompt -->
            <textarea-input-component
                :custom-class="inputClass"
                :label="__blog('Prompt')"
                :placeholder="__blog('Enter a prompt to generate content.')"
                type="textarea"
                name="prompt"
                :rows="8"
                :required="true"
                validators="required"
                v-model="params.prompt"
            />

            <!-- Configuración del contexto -->
            <select-input-component
                :custom-class="inputClass"
                :label="__blog('Language')"
                name="language"
                :required="false"
                v-model="params.context.language">
                <option v-for="(label, key) in languages" :key="key" :value="key">
                    {{ label }}
                </option>
            </select-input-component>

            <select-input-component
                :custom-class="inputClass"
                :label="__blog('Style')"
                name="style"
                :required="false"
                v-model="params.context.style">
                <option v-for="(label, key) in styles" :key="key" :value="key">
                    {{ label }}
                </option>
            </select-input-component>

            <select-input-component
                :custom-class="inputClass"
                :label="__blog('Audience')"
                name="audience"
                :required="false"
                v-model="params.context.audience">
                <option v-for="(label, key) in audiences" :key="key" :value="key">
                    {{ label }}
                </option>
            </select-input-component>

            <select-input-component
                :custom-class="inputClass"
                :label="__blog('Tone')"
                name="tone"
                :required="false"
                v-model="params.context.tone">
                <option v-for="(label, key) in tones" :key="key" :value="key">
                    {{ label }}
                </option>
            </select-input-component>

            <select-input-component
                :custom-class="inputClass"
                :label="__blog('Generate Title')"
                name="generateTitle"
                :required="false"
                v-model="params.context.title">
                <option :value="1">{{ __blog('Yes') }}</option>
                <option :value="0">{{ __blog('No') }}</option>
            </select-input-component>

            <!-- Botón para generar contenido -->
            <button-component
                @click="generateContent"
                :custom-class="buttonClass"
                :value="__blog('Generate Content')"
            />
        </div>

        <div v-if="loading" class="mt-4">
            <div class="flex flex-col items-center justify-center space-y-2">
                <!-- Icono animado -->
                <div class="animate-spin rounded-full h-10 w-10 border-t-4 border-blue-500 border-solid"></div>
                
                <!-- Mensaje dinámico -->
                <p class="text-blue-500 text-base font-semibold text-center">
                    {{ __blog('Generating content with AI') }}
                </p>
                <p class="text-blue-500 text-base font-semibold text-center">
                    {{ __blog('Do not close this window') }}
                </p>
            </div>
        </div>

        <div v-if="result" class="mt-6">
            <text-input-component
                :label="__blog('Title')"
                type="text"
                name="title"
                :required="true"
                validators="required"
                :custom-class="inputClass"
                v-model="title" />

            <editor-input-component
                class="mt-4"
                id="video-content"
                :file="true"
                :uploadUrl="fileUploadUrl"
                :onFileUploadSuccess="handleFileUploadSuccess"
                name="content"
                :height="500"
                :label="__blog('Content')"
                :placeholder="__blog('Content')"
                validators="required"
                v-model="content" />

            <button-component
                @click="submit"
                :custom-class="buttonClass"
                :value="__blog('Continue')" />
        </div>
    </div>
</template>

<script>
    import { slugify } from 'innoboxrr-js-libs/libs/string';
    import { makeHttpRequest } from 'innoboxrr-http-request';
    import {
        EditorInputComponent,
        TextareaInputComponent,
        TextInputComponent,
        SelectInputComponent,
        ButtonComponent,
    } from 'innoboxrr-form-elements';

    export default {
        components: {
            EditorInputComponent,
            TextareaInputComponent,
            TextInputComponent,
            SelectInputComponent,
            ButtonComponent,
        },
        props: {
            formId: {
                type: String,
                default: 'generateWithAIForm',
            },
            blogId: {
                type: [String, Number],
                required: true,
            },
        },
        data() {
            return {
                params: {
                    prompt: '',
                    context: {
                        language: 'spanish',
                        style:'informative',
                        audience: 'general',
                        tone: 'professional',
                        title: 1,
                    },
                },
                languages: {
                    english: 'English',
                    spanish: 'Spanish',
                    french: 'French',
                    german: 'German',
                    chinese: 'Chinese',
                },
                styles: {
                    informative: 'Informative',
                    persuasive: 'Persuasive',
                    technical: 'Technical',
                    conversational: 'Conversational',
                },
                audiences: {
                    general: 'General Audience',
                    developers: 'Developers',
                    marketers: 'Marketers',
                    educators: 'Educators',
                },
                tones: {
                    friendly: 'Friendly',
                    professional: 'Professional',
                    casual: 'Casual',
                    formal: 'Formal',
                },
                loading: false,
                result: null,
                title: '',
                content: '',
            };
        },
        methods: {

            async generateContent() {
                this.loading = true;
                this.result = null;
                let {message, title, content} = await makeHttpRequest(
                    'POST', 
                    route('api.larablog.blog.lambda'),
                    {
                        blog_id: this.blogId,
                        action: 'generateWithAI',
                        payload: {
                            prompt: this.params.prompt,
                            context: this.params.context,
                        }
                    }
                );
                this.result = {title, content};
                this.title = title;
                this.content = content;
                this.loading = false;
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
