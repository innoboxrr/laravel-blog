<template>
    <div>
        <h3 class="text-lg font-semibold mb-4">
            Configuración del Blog
        </h3>

        <!-- ALLOW COMMENTS -->
        <div>
            <label class="block font-medium text-sm mb-1">
                ¿Permitir comentarios?
            </label>
            <div class="flex gap-4">
                <div>
                    <radio-input-component
                        name="blog_allow_comments"
                        text="Sí"
                        val="1"
                        :checked="localBlog.payload.blog.allow_comments == '1'"
                        v-model="localBlog.payload.blog.allow_comments" />
                </div>
                <div>
                    <radio-input-component
                        name="blog_allow_comments"
                        text="No"
                        val="0"
                        :checked="localBlog.payload.blog.allow_comments == '0'"
                        v-model="localBlog.payload.blog.allow_comments" />
                </div>
            </div>
        </div>

        <!-- ALLOW SUBSCRIPTIONS -->
        <div class="mt-4">
            <label class="block font-medium text-sm mb-1">
                ¿Permitir suscripciones?
            </label>
            <div class="flex gap-4">
                <div>
                    <radio-input-component
                        name="blog_allow_subscriptions"
                        text="Sí"
                        val="1"
                        :checked="localBlog.payload.blog.allow_subscriptions == '1'"
                        v-model="localBlog.payload.blog.allow_subscriptions" />
                </div>
                <div>
                    <radio-input-component
                        name="blog_allow_subscriptions"
                        text="No"
                        val="0"
                        :checked="localBlog.payload.blog.allow_subscriptions == '0'"
                        v-model="localBlog.payload.blog.allow_subscriptions" />
                </div>
            </div>
        </div>

        <!-- FOOTER TEXT -->
        <textarea-input-component
            class="mt-6"
            name="blog_footer_text"
            label="Texto del pie de página"
            placeholder="Ej: Gracias por visitar nuestro blog"
            validators="length"
            :min_length="5"
            v-model="localBlog.payload.blog.footer_text" />
    </div>
</template>

<script>
import {
    RadioInputComponent,
    TextareaInputComponent,
} from 'innoboxrr-form-elements'

export default {
    name: 'StepBlogConfig',
    components: {
        RadioInputComponent,
        TextareaInputComponent,
    },
    props: {
        modelValue: {
            type: Object,
            required: true
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
                const config = val?.payload?.blog || {};
                const valid = 
                    config.allow_comments !== undefined &&
                    config.allow_subscriptions !== undefined;

                this.$emit('validated', true);
            },
            deep: true,
            immediate: true
        }
    }
}
</script>
