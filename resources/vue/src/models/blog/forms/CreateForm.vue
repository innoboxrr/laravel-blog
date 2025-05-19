<template>
    <form :id="formId" @submit.prevent>
        <WizardForm
            :form="form"
            mode="create"
            @submit="$emit('submit', $event)"
            @loadDraft="value => form = value" />
    </form>
</template>

<script>
import WizardForm from './WizardForm.vue'

export default {
    components: { WizardForm },
    props: {
        formId: {
            type: String,
            default: 'createFormForm'
        }
    },
    emits: ['submit'],
    data() {
        return {
            form: {
                name: '',
                slug: '',
                status: 'draft',
                domain: '',
                payload: {
                    
                }
            }
        }
    }
}
</script>
