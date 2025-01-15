<template>
    <div>
        <!-- Botón para mostrar formulario de añadir categoría -->
        <div class="flex justify-end mb-6">
            <button
                @click="showAddForm = !showAddForm"
                class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-md shadow hover:bg-blue-700">
                <i :class="showAddForm ? 'fas fa-times' : 'fas fa-plus'"></i>
                <span>{{ showAddForm ? 'Cerrar' : 'Añadir Categoría' }}</span>
            </button>
        </div>

        <!-- Formulario de añadir categoría -->
        <div v-if="showAddForm" class="space-y-4 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    {{ __blog('Category name') }}
                </label>
                <input
                    v-model="category.name"
                    type="text"
                    :placeholder="__blog('Ej. New Category')"
                    :class="inputClass">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    {{ __blog('Parent category') }}
                </label>
                <select
                    v-model="category.parent_id"
                    :class="inputClass">
                    <option value="">{{ __('Without parent category') }}</option>
                    <option
                        v-for="category in categories"
                        :key="category.id"
                        :value="category.id">
                        {{ categoryDashIndentation(category.level) + category.name }}
                    </option>
                </select>
            </div>
            <button
                @click="addCategory"
                class="w-full px-4 py-2 text-sm font-semibold text-white bg-green-600 rounded-md shadow hover:bg-green-700"
                :disabled="category.name.length < 3">
                <i class="fas fa-check-circle"></i>
                {{ __('Añadir Categoría') }}
            </button>
        </div>
    </div>
</template>

<script>
    import { categoryDashIndentation} from '@blogModels/blog-category/helpers/utils';
    export default {
        props: {
            categories: {
                type: Array,
                required: true,
            },
        },
        emits: ['addCategory'],
        data() {
            return {
                showAddForm: false,
                category: {
                    name: '',
                    parent_id: null,
                }
            }
        },
        methods: {
            categoryDashIndentation,
            addCategory() {
                this.$emit('addCategory', this.category);
                this.category = {
                    name: '',
                    parent_id: null,
                };
            },
        }
    }
</script>