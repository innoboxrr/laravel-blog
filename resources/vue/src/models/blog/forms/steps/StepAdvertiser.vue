<template>
    <div>
        <h3 class="text-lg font-semibold mb-4">
            Información del Anuncio
        </h3>

        <!-- SELECT: Tipo de Anuncio -->
        <select-input-component
            :custom-class="inputClass"
            name="advertisement_type"
            label="Tipo de Anuncio"
            placeholder="Selecciona el tipo de anuncio"
            validators="required"
            v-model="localBlog.payload.advertisement.type" >
            <option value="image">Imagen</option>
            <option value="code">Código Embebido</option>
        </select-input-component>

        <!-- Campos para Anuncio con Imagen -->
        <template v-if="localBlog.payload.advertisement.type == 'image'">
            <text-input-component
                :custom-class="inputClass"
                type="text"
                name="advertisement_title"
                label="Título"
                placeholder="Ej: Promoción de Verano"
                validators="required length"
                :min_length="3"
                v-model="localBlog.payload.advertisement.title" />

            <textarea-input-component
                :custom-class="inputClass"
                name="advertisement_description"
                label="Descripción"
                placeholder="Ej: Hasta 50% de descuento en productos seleccionados"
                validators="length"
                :min_length="10"
                v-model="localBlog.payload.advertisement.description" />

            <text-input-component
                :custom-class="inputClass"
                type="url"
                name="advertisement_url"
                label="URL del Anuncio"
                placeholder="https://ejemplo.com/promo"
                validators="required url"
                v-model="localBlog.payload.advertisement.url" />

            <text-input-component
                :custom-class="inputClass"
                type="text"
                name="advertisement_alt"
                label="Texto Alternativo"
                placeholder="Banner promocional"
                validators="required length"
                :min_length="3"
                v-model="localBlog.payload.advertisement.alt" />

            <div class="mb-4">
                <label class="uk-form-label">Imagen del Anuncio</label>
                <file-input-component 
                    :upload-url="fileUploadUrl"
                    :auto-upload="true"
                    :show-top-preview="true"
                    :hide-on-max-files-reached="true"
                    :valid-mimes="[ 'image/jpeg', 'image/png' ]"
                    message="Da clic o arrastra una imagen para subir"
                    @updateFileList="onImageUpload" />
            </div>
        </template>

        <!-- Campo para Código embebido -->
        <template v-else-if="localBlog.payload.advertisement.type == 'code'">
            <textarea-input-component
                :custom-class="inputClass"
                name="advertisement_code"
                label="Código HTML/JS"
                placeholder="Pega aquí el código del anuncio (HTML, JS, etc)"
                validators="required length"
                :min_length="10"
                v-model="localBlog.payload.advertisement.code" />
        </template>
    </div>
</template>

<script>
import {
    TextInputComponent,
    TextareaInputComponent,
    FileInputComponent,
    SelectInputComponent,
} from 'innoboxrr-form-elements'

export default {
    name: 'StepAdvertiser',
    components: {
        TextInputComponent,
        TextareaInputComponent,
        FileInputComponent,
        SelectInputComponent,
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
            fileUploadUrl: '/upload'
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
        onImageUpload(files) {
            if (files?.[0]?.path) {
                this.localBlog.payload.advertisement.image = files[0].path;
            }
        }
    },
    watch: {
        localBlog: {
            handler(val) {
                const ad = val?.payload?.advertisement || {};
                let valid = false;

                if (ad.type === 'code') {
                    valid = ad.code?.length >= 10;
                } else {
                    valid =
                        ad.title?.length >= 3 &&
                        ad.url?.startsWith('http') &&
                        ad.alt?.length >= 3 &&
                        !!ad.image;
                }

                this.$emit('validated', valid);
            },
            deep: true,
            immediate: true
        }
    }
}
</script>
