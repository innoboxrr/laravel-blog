<template>
    <form :id="formId" @submit.prevent>
        <WizardForm
            v-if="blog"
            :blog="blog"
            mode="edit"
            @submit="$emit('submit', $event)" />
    </form>
</template>

<script>
import { showModel } from '@blogModels/blog'
import WizardForm from './WizardForm.vue'

export default {
    components: { WizardForm },
    props: {
        formId: {
            type: String,
            default: 'editFormForm'
        },
        blogId: {
            type: [String, Number],
            required: true
        }
    },
    emits: ['submit'],
    data() {
        return {
            blog: null
        }
    },
    async mounted() {
        await this.fetchData();
    },
    methods: {
        async fetchData() {
            try {
                const rawBlog = await this.fetchBlog();
                this.blog = rawBlog;
            } catch (error) {
                console.error('Error loading blog:', error)
            }
        },
        async fetchBlog() {
            const response = await showModel(this.blogId);
            return response;
        }
    }
}
</script>
