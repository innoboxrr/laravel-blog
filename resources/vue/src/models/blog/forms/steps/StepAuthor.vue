<template>
    <div>
        <h3 class="text-lg font-semibold mb-2">
            Información del Autor
        </h3>

        <!-- AUTHOR NAME -->
        <text-input-component
            :custom-class="inputClass"
            type="text"
            name="author_name"
            label="Nombre del Autor"
            placeholder="Ej: Juan Pérez"
            validators="required length"
            :min_length="3"
            v-model="localBlog.payload.author.name" />

        <!-- AUTHOR EMAIL -->
        <text-input-component
            :custom-class="inputClass"
            type="email"
            name="author_email"
            label="Correo Electrónico"
            placeholder="Ej: juan@ejemplo.com"
            validators="required email"
            v-model="localBlog.payload.author.email" />

        <!-- AUTHOR BIO -->
        <textarea-input-component
            :custom-class="inputClass"
            name="author_bio"
            label="Biografía"
            placeholder="Breve descripción del autor"
            validators="length"
            :min_length="10"
            v-model="localBlog.payload.author.bio" />

        <!-- AUTHOR AVATAR -->
        <div>
            <label class="uk-form-label">Avatar</label>
            <file-input-component 
                :upload-url="fileUploadUrl"
                :auto-upload="true"
                :show-top-preview="true"
                :hide-on-max-files-reached="true"
                :valid-mimes="[ 'image/jpeg', 'image/png' ]"
                message="Da clic o arrastra una imagen para subir"
                @updateFileList="onAvatarUpload" />
        </div>
    </div>
</template>

<script>
import {
    TextInputComponent,
    TextareaInputComponent,
    FileInputComponent,
} from 'innoboxrr-form-elements'

export default {
    name: 'StepAuthor',
    components: {
        TextInputComponent,
        TextareaInputComponent,
        FileInputComponent,
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
    data() {
        return {
            fileUploadUrl: '/upload' // ajusta según tu endpoint real
        }
    },
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
        onAvatarUpload(files) {
            if (files?.[0]?.path) {
                this.localBlog.payload.author.avatar = files[0].path;
            }
        }
    },
    watch: {
        localBlog: {
            handler(val) {
                console.log(val);
                const author = val?.payload?.author || {};
                const valid =
                    author.name?.length >= 3 &&
                    !!author.email;

                this.$emit('validated', valid);
            },
            deep: true,
            immediate: true
        }
    },
}
</script>
