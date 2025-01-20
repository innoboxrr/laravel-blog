<template>
    <div class="max-w-md mx-auto bg-white rounded-lg">

        <create-category 
            :key="'create-category-' + key"
            :blog-id="blog.id"
            @showCreateForm="showCreateForm = $event"
            @categoryCreated="addCategory" />

        <div v-show="!showCreateForm">
            <category-select
                :key="'category-select-' + key"
                :blog-id="blog.id"
                :preselected="selectedCategories"
                @categoriesLoaded="categories = $event"
                @categorySelected="selectCategory" />

            <selected-categories 
                v-if="selectedCategories.length"
                :key="'selected-categories-' + key"
                :preselected="selectedCategories"
                @editCategory="editCategory"
                @removeCategory="removeCategory" />
            
            <edit-category-modal 
                v-if="categoryBeingEdited"
                :key="'edit-category-modal-' + key"
                :categories="categories"
                :category-being-edited="categoryBeingEdited"
                @cancelEdit="cancelEdit"
                @saveCategoryEdit="saveCategoryEdit" />
        </div>

    </div>
</template>

<script>
    import { sortCategories } from '@blogModels/blog-category/helpers/utils';
    import CreateCategory from './CreateCategory.vue';
    import CategorySelect from './CategorySelect.vue';
    import SelectedCategories from './SelectedCategories.vue';
    import EditCategoryModal from './EditCategoryModal.vue';

    export default {
        name: 'CompactCategorySelector',
        components: {
            CreateCategory,
            CategorySelect,
            SelectedCategories,
            EditCategoryModal,
        },
        props: {
            blog: {
                type: Object,
                required: true,
            },
            preselectedCategories: {
                type: Array,
                default: () => [],
            },
        },
        emits: ['onChangeCategories'],
        data() {
            return {
                key: 0,
                showCreateForm: false,
                categories: [],
                selectedCategories: [...this.preselectedCategories],
                categoryBeingEdited: null,
            };
        },
        watch: {
            selectedCategories: {
                handler(categories) {
                    this.$emit('onChangeCategories', categories);
                },
                deep: true,
            },
        },
        methods: {
            addCategory(category) {
                this.showCreateForm = false;
                ++this.key;
            },
            selectCategory(category) {
                if (!this.selectedCategories.some(cat => cat.id === category.id)) {
                    this.selectedCategories.push(category); 
                }
                this.selectedCategories = sortCategories(this.selectedCategories, this.categories);
                ++this.key;
            },
            editCategory(category) {
                this.categoryBeingEdited = category;
            },
            removeCategory(categoryId) {
                this.selectedCategories = this.selectedCategories.filter(category => category.id !== categoryId);
                this.key++;
            },
            cancelEdit() {
                this.categoryBeingEdited = null;
            },
            saveCategoryEdit(category) {
                const index = this.selectedCategories.findIndex(c => c.id === category.id);
                this.selectedCategories[index] = category;
                this.categoryBeingEdited = null;
                this.key++;
            },
        },
    };
</script>
