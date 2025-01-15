<template>
    <!-- Modal de edición -->
    <div class="fixed inset-0 z-10 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 space-y-4 max-w-sm w-full">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">{{ __('Editar Categoría') }}</h3>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de la categoría</label>
                <input
                    v-model="categoryBeingEdited.name"
                    type="text"
                    placeholder="Ej. Editar Categoría"
                    :class="inputClass">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Categoría superior</label>
                <select
                    v-model="categoryBeingEdited.parent_id"
                    :class="inputClass">
                    <option value="">{{ __('Sin categoría superior') }}</option>
                    <option
                        v-for="category in flattenedCategories"
                        :key="category.id"
                        :value="category.id"
                        :disabled="category.id === categoryBeingEdited.id">
                        {{ categoryDashIndentation(category.level) + category.name }}
                    </option>
                </select>
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
    export default {
        props: {
            categoryBeingEdited: {
                type: Object,
                required: true,
            },
        },
        emits: ['saveCategoryEdit', 'cancelEdit'],
        data() {
            return {
                category: this.categoryBeingEdited,
            }
        },
        methods: {
            cancelEdit() {
                this.$emit('cancelEdit');
            },
            saveCategoryEdit() {
                this.$emit('saveCategoryEdit', this.category);
            },
        }
    }
</script>