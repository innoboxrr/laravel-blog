<template>
    <div class="w-full max-w-screen-xl mx-auto">
        <h2 class="text-2xl font-bold">
            {{ mode === 'edit' ? 'Editar Formulario' : 'Crear Formulario' }}
        </h2>
        <p class="text-gray-400 mb-6">
            Llena los campos para {{ mode === 'edit' ? 'actualizar' : 'crear' }} el Blog
        </p>

        <div class="flex flex-col md:flex-row gap-6 items-start">
            <ol class="space-y-4 w-full md:w-[200px] shrink-0">
                <li
                    v-for="(step, i) in currentSteps"
                    :key="i"
                    @click="goToStep(i)"
                    class="cursor-pointer">
                    <div
                        class="w-full p-4 border rounded-lg flex items-center justify-between gap-2"
                        :class="[
                            stepClass(step),
                            step.active ? 'ring-2 ring-offset-1 ring-blue-500' : '',
                        ]">
                        <h3 :class="step.active ? 'font-bold' : 'font-medium'" class="text-sm md:text-base">
                            {{ step.title }}
                        </h3>
                        <svg v-if="step.completed" class="w-4 h-4" fill="none" viewBox="0 0 16 12">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                        </svg>
                    </div>
                </li>
                <button-component v-if="mode === 'create'" @click="resetLocal" value="Reiniciar" />
            </ol>

            <div class="flex-1 w-full space-y-6">
                <component
                    :is="currentComponent"
                    :model-value="blog"
                    :mode="mode"
                    @update:modelValue="blog = $event"
                    @validated="onStepValidated" />

                <div class="flex flex-wrap gap-2 justify-between">
                    <button-component 
                        v-if="stepIndex > 0" 
                        @click="prevStep" 
                        value="Anterior" />
                    <button-component 
                        v-if="!isLastStep" 
                        :disabled="!steps[stepIndex].valid" 
                        @click="nextStep" 
                        value="Siguiente" />
                    <button-component 
                        v-else 
                        :disabled="!steps[stepIndex].valid" 
                        @click="submit" 
                        :value="mode === 'edit' ? 'Actualizar' : 'Crear'" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import StepGeneral from './steps/StepGeneral.vue'
import StepAuthor from './steps/StepAuthor.vue'
import StepAuthorSocial from './steps/StepAuthorSocial.vue'
import StepBlogConfig from './steps/StepBlogConfig.vue'
import StepBlogSocial from './steps/StepBlogSocial.vue'

import { ButtonComponent } from 'innoboxrr-form-elements'
import { createModel, updateModel } from '@blogModels/blog'
import Swal from 'sweetalert2'

export default {
    components: {
        StepGeneral,
        StepAuthor,
        StepAuthorSocial,
        StepBlogConfig,
        StepBlogSocial,
        ButtonComponent,
    },
    props: {
        blog: { 
            type: Object, 
            required: true 
        },
        mode: { 
            type: String, 
            default: 'create' 
        }
    },
    emits: [
        'submit', 
        'loadDraft'
    ],
    data() {
        return {
            stepIndex: 0,
            steps: [
                { title: 'Inicio', component: 'StepGeneral', valid: false, completed: false, active: true },
                { title: 'Autor', component: 'StepAuthor', valid: false, completed: false, active: false },
                { title: 'Author Network', component: 'StepAuthorSocial', valid: false, completed: false, active: false },
                { title: 'Blog', component: 'StepBlogConfig', valid: false, completed: false, active: false },
                { title: 'Blog Network', component: 'StepBlogSocial', valid: false, completed: false, active: false },
            ],
            storageKey: null,
            hasChanges: false,
        }
    },
    computed: {
        currentSteps() {
            return this.steps
        },
        currentComponent() {
            return this.steps[this.stepIndex].component
        },
        isLastStep() {
            return this.stepIndex === this.steps.length - 1
        }
    },
    watch: {
        blog: {
            handler(newVal) {
                this.hasChanges = true
                if (this.mode === 'create' && this.storageKey) {
                    localStorage.setItem(this.storageKey, JSON.stringify(newVal))
                }
            },
            deep: true
        }
    },
    mounted() {

        if (this.mode === 'create') {
            const url = new URL(window.location.href)
            let id = url.searchParams.get('draft')
            if (!id) {
                id = crypto.randomUUID()
                url.searchParams.set('draft', id)
                window.history.replaceState({}, '', url)
            }
            this.storageKey = `draft_blog_${id}`
            const saved = localStorage.getItem(this.storageKey)
            if (saved) {
                this.$emit('loadDraft', JSON.parse(saved))
            }
        }

        window.addEventListener('beforeunload', this.handleExit)
    },
    beforeUnmount() {
        window.removeEventListener('beforeunload', this.handleExit)
    },
    methods: {
        stepClass(step) {
            if (step.completed) return 'text-green-700 border-green-300 bg-green-50'
            if (step.active) return 'text-blue-700 border-blue-300 bg-blue-100'
            return 'text-gray-900 border-gray-300 bg-gray-100'
        },
        onStepValidated(valid) {
            const step = this.steps[this.stepIndex]
            step.valid = valid
            step.completed = valid
        },
        nextStep() {
            this.steps[this.stepIndex].active = false
            this.stepIndex++
            this.steps[this.stepIndex].active = true
        },
        prevStep() {
            this.steps[this.stepIndex].active = false
            this.stepIndex--
            this.steps[this.stepIndex].active = true
        },
        goToStep(index) {
            this.steps[this.stepIndex].active = false
            this.stepIndex = index
            this.steps[this.stepIndex].active = true
        },
        submit() {


            const data = {
                name: this.blog.name,
                slug: this.blog.slug,
                status: this.blog.status,
                domain: this.blog.domain,
                ...this.blog.payload,
            }

            const handler = this.mode === 'edit'
                ? updateModel(this.blog.id, data)
                : createModel(data)

            handler.then(res => {
                if (this.storageKey) localStorage.removeItem(this.storageKey);
                this.$emit('submit', res);
                console.log('Blog saved:', res);
                Swal.fire({
                    icon: 'success',
                    title: this.mode === 'edit' ? 'Blog actualizado' : 'Blog creado',
                    text: this.mode === 'edit' ? 'El blog ha sido actualizado correctamente.' : 'El blog ha sido creado correctamente.',
                    showConfirmButton: true,
                });

            }).catch(error => {
                if (error?.response?.status === 422) {
                    // Manejo opcional
                }
            })
        },
        handleExit(e) {
            if (this.mode === 'create' && this.hasChanges) {
                e.preventDefault()
                e.returnValue = ''
                return ''
            }
        },
        resetLocal() {
            if (this.storageKey) {
                localStorage.removeItem(this.storageKey)
                window.location.reload()
            }
        }
    }
}
</script>
