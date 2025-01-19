<template>
    <div class="max-w-md mx-auto bg-white rounded-lg">

        <create-category 
            :key="'create-category-' + key"
            :blog-id="blog.id"
            @categoryCreated="addCategory" />

        <category-select
            :key="'category-select-' + key"
            :blog-id="blog.id"
            :preselected="selectedCategories"
            @categoriesLoaded="categories = $event"
            @categorySelected="addCategory" />

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
</template>

<script>

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
                categories: [],
                selectedCategories: [...this.preselectedCategories],
                categoryBeingEdited: null,
            };
        },
        methods: {
            addCategory(category) {
                
                // Primero añadimos la categoría a la lista
                this.selectedCategories.push(category);


                // 5. Emitir un evento para notificar los cambios
                this.$emit('onChangeCategories', this.selectedCategories);

                // 6. Incrementar la clave para forzar la actualización visual si es necesario
                ++this.key;
            },
            editCategory(category) {
                this.categoryBeingEdited = category;
            },
            removeCategory(categoryId) {
                this.selectedCategories = this.selectedCategories.filter(category => category.id !== categoryId);
                this.key++;
                this.$emit('onChangeCategories', this.selectedCategories);
            },
            cancelEdit() {
                this.categoryBeingEdited = null;
            },
            saveCategoryEdit(category) {
                const index = this.selectedCategories.findIndex(c => c.id === category.id);
                this.selectedCategories[index] = category;
                this.categoryBeingEdited = null;
                this.key++;
                this.$emit('onChangeCategories', this.selectedCategories);
            },
        },
    };
</script>
