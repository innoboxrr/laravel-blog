<template>
    <!-- Modal de edición -->
    <div class="fixed inset-0 z-999 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 space-y-4 max-w-sm w-full">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __blog('Editar Categoría') }}</h3>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de la categoría</label>
                <input
                    v-model="category.name"
                    type="text"
                    placeholder="Ej. Editar Categoría"
                    :class="inputClass">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Categoría superior</label>
                <select
                    v-model="category.parent_id"
                    :class="inputClass">
                    <option value="">{{ __blog('Sin categoría superior') }}</option>
                    <option
                        v-for="cat in categories"
                        :key="cat.id"
                        :value="cat.id"
                        :disabled="cat.id === category.id || cat.parent_id === category.id">
                        {{ categoryDashIndentation(cat.level) + cat.name }}
                    </option>
                </select>
            </div>
            <div>
                <textarea-input-component
                    :label="__blog('Description')"
                    :placeholder="__blog('Describe the category to improve SEO')"
                    name="description"
                    v-model="category.description"
                    :custom-class="inputClass"
                    validators="required length"
                    min_length="3"
                    max_length="255"
                    required />
            </div>
            <div class="flex justify-end space-x-2">
                <button
                    @click="cancelEdit"
                    class="px-4 py-2 text-sm font-semibold text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300">
                    Cancelar
                </button>
                <button
                    @click="saveCategoryEdit"
                    class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-md hover:bg-blue-700">
                    Guardar
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import { updateModel as updateCategoryModel } from '@blogModels/blog-category'
    import { categoryDashIndentation } from '@blogModels/blog-category/helpers/utils';
    import { TextareaInputComponent } from 'innoboxrr-form-elements'
    export default {
        components: {
            TextareaInputComponent,
        },
        props: {
            categories: {
                type: Array,
                required: true,
            },
            categoryBeingEdited: {
                type: Object,
                required: true,
            },
        },
        emits: ['saveCategoryEdit', 'cancelEdit'],
        data() {
            return {
                category: {...this.categoryBeingEdited},
            }
        },
        methods: {
            categoryDashIndentation,
            cancelEdit() {
                this.$emit('cancelEdit');
            },
            async saveCategoryEdit() {
                await updateCategoryModel(this.category.id, this.category);
                this.$emit('saveCategoryEdit', this.category);
            },
        }
    }
</script>