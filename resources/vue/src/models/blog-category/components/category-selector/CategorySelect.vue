<template>
    <div>
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                {{ __blog('Select a category') }}
            </label>
            <select
                v-model="selectedCategoryId"
                @change="selectCategory"
                :class="inputClass">
                <option value="">{{ __('Selecciona una categoría') }}</option>
                <option
                    v-for="category in categories"
                    :key="category.id"
                    :value="category.id"
                    :disabled="isCategorySelected(category.id)"
                    :class="isCategorySelected(category.id) ? 'cursor-not-allowed opacity-50' : ''">
                    {{ categoryDashIndentation(category.level) + category.name }}
                </option>
            </select>
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
            preselected: {
                type: Array,
                default: () => [],
            },
        },
        data() {
            return {
                selectedCategoryId: '',
                selectedCategories: this.preselected,
            };
        },
        methods: {
            categoryDashIndentation,
            selectCategory() {
                const category = this.categories.find(
                    (cat) => cat.id === parseInt(this.selectedCategoryId)
                );

                if (category) {
                    this.addToSelectedCategories(category);
                }

                this.selectedCategoryId = '';
            },
            addToSelectedCategories(category) {
                if (!this.isCategorySelected(category.id)) {
                    this.selectedCategories.push({ ...category });
                }

                let parentId = category.parent_id;
                while (parentId) {
                    const parent = this.categories.find((cat) => cat.id === parentId);
                    if (parent && !this.isCategorySelected(parent.id)) {
                        this.selectedCategories.push({ ...parent });
                    }
                    parentId = parent?.parent_id || null;
                }

                this.reorderSelectedCategories();

                console.log('Selected Categories:', this.selectedCategories); // Debugging
            },
            isCategorySelected(id) {
                return this.selectedCategories.some((cat) => cat.id === id);
            },
        }
    }
</script>