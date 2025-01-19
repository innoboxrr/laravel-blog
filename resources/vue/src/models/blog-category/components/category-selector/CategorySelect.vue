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
                <option value="">{{ __blog('Selecciona una categoría') }}</option>
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
    import { 
        indexModel 
    } from '@blogModels/blog-category'
    import { 
        createFlattenedCategories, 
        categoryDashIndentation
    } from '@blogModels/blog-category/helpers/utils';
    export default {
        props: {
            blogId: {
                type: Number,
                required: true,
            },
            preselected: {
                type: Array,
                default: () => [],
            },
        },
        emits: ['categoriesLoaded', 'categorySelected'],
        data() {
            return {
                categories: [],
                selectedCategoryId: '',
                selectedCategories: this.preselected,
            };
        },
        mounted() {
            this.fetchData();
        },
        methods: {
            createFlattenedCategories,
            categoryDashIndentation,
            async fetchData() {
                await this.fetchCategories();
            },
            async fetchCategories() {
                let categories = await indexModel({
                    paginate: 0,
                    only_parents: true,
                    blog_id: this.blogId,
                    load_children: true,
                });
                this.categories = this.createFlattenedCategories(categories);
                this.$emit('categoriesLoaded', this.categories);
            },
            selectCategory() {
                let category = this.categories.find((cat) => cat.id === this.selectedCategoryId);
                if (category) {
                    this.$emit('categorySelected', category);
                    this.selectedCategoryId = '';
                }
            },
            isCategorySelected(id) {
                return this.selectedCategories.some((cat) => cat.id === id);
            },
        }
    }
</script>