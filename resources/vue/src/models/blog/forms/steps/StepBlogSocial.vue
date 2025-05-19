<template>
    <div>
        <h3 class="text-lg font-semibold mb-2">
            Redes Sociales del Blog
        </h3>

        <div class="grid md:grid-cols-2 gap-4">

            <div
                v-for="(label, key) in socialNetworks"
                :key="key">
                <text-input-component
                    :custom-class="inputClass"
                    :name="`blog_social_${key}`"
                    type="url"
                    :label="label"
                    :placeholder="`https://${key}.com/`"
                    validators="url"
                    v-model="localBlog.payload.blog.social[key]" />
            </div>
        </div>
    </div>
</template>

<script>
import { TextInputComponent } from 'innoboxrr-form-elements'

export default {
    name: 'StepBlogSocialForm',
    components: {
        TextInputComponent,
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
        },
        socialNetworks() {
            return {
                'x-twitter': 'Twitter',
                'facebook': 'Facebook',
                'instagram': 'Instagram',
                'linkedin': 'LinkedIn',
                'github': 'GitHub',
                'tiktok': 'TikTok',
                'youtube': 'YouTube',
                'pinterest': 'Pinterest',
                'snapchat': 'Snapchat',
                'whatsapp': 'WhatsApp',
                'telegram': 'Telegram',
                'discord': 'Discord',
                'reddit': 'Reddit',
            }
        }
    },
    watch: {
        localBlog: {
            handler() {
                // Validación: al menos una red social válida
                // const social = this.localBlog?.payload?.blog?.social || {};
                // const atLeastOneFilled = Object.values(social).some(val => Array.isArray(val) ? val.length : !!val);

                this.$emit('validated', true);
            },
            deep: true,
            immediate: true
        }
    }
}
</script>
