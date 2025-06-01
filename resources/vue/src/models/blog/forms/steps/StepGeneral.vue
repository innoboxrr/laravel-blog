<template>
    <div>
        <h3 class="text-lg font-semibold mb-2">
            Información General
        </h3>

        <!-- NAME -->
        <text-input-component
            :custom-class="inputClass"
            type="text"
            name="name"
            label="Nombre del Blog"
            placeholder="Ej: Mi Blog"
            validators="required length"
            :min_length="3"
            :max_length="100"
            v-model="localBlog.name" />

        <!-- SLUG -->
        <text-input-component
            :custom-class="inputClass"
            type="text"
            name="slug"
            label="Slug"
            placeholder="Ej: formulario-registro"
            validators="required alpha_dash"
            v-model="localBlog.slug" />

        <!-- STATUS -->
        <select-input-component
            :custom-class="inputClass"
            name="status"
            label="Estado"
            validators="required"
            v-model="localBlog.status">
            <option value="draft">Borrador</option>
            <option value="active">Activo</option>
            <option value="archived">Archivado</option>
        </select-input-component>

        <!-- THEME -->
        <select-input-component
            :custom-class="inputClass"
            name="theme"
            label="Tema"
            help="Estamos trabajando para añadir más temas"
            validators="required"
            v-model="localBlog.payload.blog.theme">
            <option value="default">Default</option>
        </select-input-component>

        <!-- DOMAIN -->
        <text-input-component
            :custom-class="inputClass"
            type="text"
            name="domain"
            label="Dominio del Blog"
            placeholder="Ej: miblog.com"
            help="El dominio puede adquirirse o configurarse más adelante"
            validators="required host"
            v-model="localBlog.domain" />

        <!-- BLOG DESCRIPTION -->
        <textarea-input-component
            :custom-class="inputClass"
            name="description"
            label="Descripción del Blog"
            placeholder="Breve descripción del blog"
            validators="required length"
            :min_length="10"
            :max_length="300"
            v-model="localBlog.payload.blog.description" />

        <!-- BLOG KEYWORDS -->
        <tags-input-component
            :custom-class="inputClass"
            name="keywords"
            label="Palabras clave del blog"
            placeholder="Ej: tecnología, viajes, programación"
            v-model="localBlog.payload.blog.keywords" />

        <!-- BLOG LOGO -->
        <div class="mt-4">
            <label class="uk-form-label">Logo del Blog</label>
            <file-input-component 
                :upload-url="fileUploadUrl"
                :auto-upload="true"
                :show-top-preview="true"
                :hide-on-max-files-reached="true"
                :valid-mimes="[ 'image/jpeg', 'image/png' ]"
                message="Da clic o arrastra una imagen para subir"
                @updateFileList="onBlogLogoUpload" />
        </div>

        <!-- BLOG FAVICON -->
        <div class="mt-4">
            <label class="uk-form-label">Favicon del Blog</label>
            <file-input-component 
                :upload-url="fileUploadUrl"
                :auto-upload="true"
                :show-top-preview="true"
                :hide-on-max-files-reached="true"
                :valid-mimes="[ 'image/png', 'image/x-icon' ]"
                message="Da clic o arrastra una imagen para subir"
                @updateFileList="onBlogFaviconUpload" />
        </div>

        <!-- APPLE TOUCH ICON -->
        <div class="mt-4">
            <label class="uk-form-label">Apple Touch Icon</label>
            <file-input-component 
                :upload-url="fileUploadUrl"
                :auto-upload="true"
                :show-top-preview="true"
                :hide-on-max-files-reached="true"
                :valid-mimes="[ 'image/png' ]"
                message="Sube una imagen para Apple Touch"
                @updateFileList="onAppleTouchIconUpload" />
        </div>

        <!-- FAVICON 32 -->
        <div class="mt-4">
            <label class="uk-form-label">Favicon 32x32</label>
            <file-input-component 
                :upload-url="fileUploadUrl"
                :auto-upload="true"
                :show-top-preview="true"
                :hide-on-max-files-reached="true"
                :valid-mimes="[ 'image/png' ]"
                message="Sube el favicon 32x32"
                @updateFileList="onFavicon32Upload" />
        </div>

        <!-- FAVICON 16 -->
        <div class="mt-4">
            <label class="uk-form-label">Favicon 16x16</label>
            <file-input-component 
                :upload-url="fileUploadUrl"
                :auto-upload="true"
                :show-top-preview="true"
                :hide-on-max-files-reached="true"
                :valid-mimes="[ 'image/png' ]"
                message="Sube el favicon 16x16"
                @updateFileList="onFavicon16Upload" />
        </div>

        <!-- SAFARI MASK ICON -->
        <div class="mt-4">
            <label class="uk-form-label">Safari Mask Icon</label>
            <file-input-component 
                :upload-url="fileUploadUrl"
                :auto-upload="true"
                :show-top-preview="true"
                :hide-on-max-files-reached="true"
                :valid-mimes="[ 'image/svg+xml' ]"
                message="Sube el icono para Safari"
                @updateFileList="onSafariMaskIconUpload" />
        </div>

    </div>
</template>

<script>
import {
    TextInputComponent,
    SelectInputComponent,
    TextareaInputComponent,
    FileInputComponent,
    TagsInputComponent,
} from 'innoboxrr-form-elements'

export default {
    name: 'StepGeneralForm',
    components: {
        TextInputComponent,
        SelectInputComponent,
        TextareaInputComponent,
        FileInputComponent,
        TagsInputComponent,
    },
    props: {
        modelValue: {
            type: Object,
            required: true
        },
        mode: {
            type: String,
            default: 'create'
        }
    },
    emits: ['update:modelValue', 'validated'],
    computed: {
        localBlog: {
            get() {
                return this.modelValue
            },
            set(value) {
                this.$emit('update:modelValue', value)
            }
        }
    },
    methods: {
        onBlogLogoUpload(files) {
            if (files?.[0]?.path) {
                this.localBlog.payload.blog.logo = files[0].path;
            }
        },
        onBlogFaviconUpload(files) {
            if (files?.[0]?.path) {
                this.localBlog.payload.blog.favicon = files[0].path;
            }
        },
        onAppleTouchIconUpload(files) {
            if (files?.[0]?.path) {
                this.localBlog.payload.blog.appleTouchIcon = files[0].path;
            }
        },
        onFavicon32Upload(files) {
            if (files?.[0]?.path) {
                this.localBlog.payload.blog.favicon32 = files[0].path;
            }
        },
        onFavicon16Upload(files) {
            if (files?.[0]?.path) {
                this.localBlog.payload.blog.favicon16 = files[0].path;
            }
        },
        onSafariMaskIconUpload(files) {
            if (files?.[0]?.path) {
                this.localBlog.payload.blog.safariMaskIcon = files[0].path;
            }
        }
    },
    watch: {
        localBlog: {
            handler(val) {
                const blog = val?.payload?.blog || {};
                const valid =
                    val.name?.length >= 3 &&
                    !!val.slug &&
                    !!val.status &&
                    !!val.domain &&
                    blog.description?.length >= 10;

                this.$emit('validated', valid);
            },
            deep: true,
            immediate: true
        }
    },
}
</script>
