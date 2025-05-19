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
            label="Nombre del Formulario"
            placeholder="Ej: Formulario de registro"
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

        <!-- Theme -->
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
    </div>
</template>

<script>
import {
    TextInputComponent,
    SelectInputComponent,
} from 'innoboxrr-form-elements'

export default {
    name: 'StepGeneralForm',
    components: {
        TextInputComponent,
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
    watch: {
        localBlog: {
            handler(val) {

                console.log('validating', val);

                const valid =
                    val.name?.length >= 3 &&
                    !!val.slug &&
                    !!val.status &&
                    !!val.domain;

                this.$emit('validated', valid);
            },
            deep: true,
            immediate: true
        }
    },
}
</script>
