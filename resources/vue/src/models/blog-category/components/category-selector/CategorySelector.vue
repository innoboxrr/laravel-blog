<template>
    <div class="max-w-md mx-auto bg-white rounded-lg">

        <create-category-form 
            :categories="flattenedCategories"
            @addCategory="addCategory" />

        <category-select
            :categories="flattenedCategories"
            :preselected="selectedCategories"
            @select="appendCategory" />

        <selected-categories 
            :preselected="selectedCategories" />
        
        <edit-category-modal 
            v-if="categoryBeingEdited"
            :category-being-edited="categoryBeingEdited" />

    </div>
</template>

<script>
    import { categoryDashIndentation} from '@blogModels/blog-category/helpers/utils';
    import CreateCategoryForm from './CreateCategoryForm.vue';
    import CategorySelect from './CategorySelect.vue';
    import SelectedCategories from './SelectedCategories.vue';
    import EditCategoryModal from './EditCategoryModal.vue';

    export default {
        name: 'CompactCategorySelector',
        components: {
            CreateCategoryForm,
            CategorySelect,
            SelectedCategories,
            EditCategoryModal,
        },
        props: {
            preselectedCategories: {
                type: Array,
                default: () => [],
            },
        },
        data() {
            return {
                categories: [
                    {
                        id: 1,
                        name: "Category 1",
                        parent_id: null,
                        children: [
                            {
                                id: 2,
                                name: "Subcategory 1.1",
                                parent_id: 1,
                                children: [
                                    {
                                        id: 3,
                                        name: "Subcategory 1.1.1",
                                        parent_id: 2,
                                        children: [],
                                    },
                                    {
                                        id: 4,
                                        name: "Subcategory 1.1.2",
                                        parent_id: 2,
                                        children: [],
                                    },
                                ],
                            },
                            {
                                id: 5,
                                name: "Subcategory 1.2",
                                parent_id: 1,
                                children: [],
                            },
                        ],
                    },
                    {
                        id: 6,
                        name: "Category 2",
                        parent_id: null,
                        children: [
                            {
                                id: 7,
                                name: "Subcategory 2.1",
                                parent_id: 6,
                                children: [],
                            },
                        ],
                    },
                ],
            
                selectedCategories: [...this.preselectedCategories],
                flattenedCategories: [],
                categoryBeingEdited: null,
            };
        },
        mounted() {
            this.flattenedCategories = this.createFlattenedCategories(this.categories);
        },
        watch: {
            categories: {
                handler() {
                    this.updateFlattenedCategories();
                    this.reorderSelectedCategories();
                },
                deep: true,
            },
        },
        methods: {
            categoryDashIndentation,
            createFlattenedCategories(categories, level = 0) {
                return categories.reduce((acc, category) => {
                    acc.push({ ...category, level });
                    if (category.children && category.children.length) {
                        acc.push(...this.createFlattenedCategories(category.children, level + 1));
                    }
                    return acc;
                }, []);
            },

            addCategory(category) {
                this.addToHierarchy(category);
                this.updateFlattenedCategories();
                // this.addToSelectedCategories(newCategory); // Este método se pasó a CategorySelect
            },

            appendCategory(category) {
                // this.addToSelectedCategories(category);
            },


            ////////////////////////////////////////////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////
            ////////////////////////////////////////////////////////////////////////////////
            

            addToHierarchy(category) {
                if (category.parent_id) {
                    const parent = this.categories.find((cat) => cat.id === category.parent_id);
                    if (parent) {
                        parent.children = parent.children || [];
                        parent.children.push(category);
                    }
                } else {
                    this.categories.push(category);
                }
                this.$emit('update:categories', this.categories); // Notifica al padre sobre el cambio
            },
            updateFlattenedCategories() {
                this.flattenedCategories = this.createFlattenedCategories(this.categories);
            },
            
            
            reorderSelectedCategories() {
                const reorder = (categories, level = 0) => {
                    const selectedIds = new Set(this.selectedCategories.map((cat) => cat.id));
                    return categories.reduce((acc, category) => {
                        if (selectedIds.has(category.id)) {
                            acc.push({ ...category, level });
                        }
                        if (category.children && category.children.length) {
                            acc.push(...reorder(category.children, level + 1));
                        }
                        return acc;
                    }, []);
                };

                this.selectedCategories = reorder(this.categories);
            },
            removeCategory(id) {
                const descendantIds = this.getDescendantIds(this.flattenedCategories, id);

                this.selectedCategories = this.selectedCategories.filter(
                    (cat) => cat.id !== id && !descendantIds.includes(cat.id)
                );
            },
            getDescendantIds(categories, parentId) {
                return categories.reduce((acc, category) => {
                    if (category.parent_id === parentId) {
                        acc.push(category.id, ...this.getDescendantIds(categories, category.id));
                    }
                    return acc;
                }, []);
            },
            cancelEdit() {
                this.categoryBeingEdited = null;
            },
            editCategory(category) {
                // Copia de la categoría para editar sin afectar el original hasta confirmar
                this.categoryBeingEdited = { ...category };
            },
            saveCategoryEdit() {
                const { id, parent_id, name } = this.categoryBeingEdited;

                console.log('Saving Category Edit:', id, parent_id, name);

                // Actualizar el nombre en flattenedCategories
                this.flattenedCategories = this.flattenedCategories.map((category) => {
                    if (category.id === id) {
                        return { ...category, name };
                    }
                    return category;
                });

                // Actualizar el nombre en selectedCategories
                this.selectedCategories = this.selectedCategories.map((category) => {
                    if (category.id === id) {
                        return { ...category, name };
                    }
                    return category;
                });

                // Verificar si cambió el parent_id
                const originalCategory = this.flattenedCategories.find((cat) => cat.id === id);
                if (originalCategory?.parent_id !== parent_id) {
                    // Remover de la jerarquía actual
                    this.removeFromHierarchy(id);

                    // Actualizar el parent_id
                    const updatedCategory = { ...originalCategory, parent_id };

                    // Reinsertar en la nueva ubicación jerárquica
                    this.addToHierarchy(updatedCategory);

                    // Actualizar en flattenedCategories
                    this.flattenedCategories = this.createFlattenedCategories(this.categories);
                }

                // Actualizar las listas seleccionadas y jerarquizadas
                this.updateFlattenedCategories();
                this.updateSelectedCategories();

                // Limpiar el estado de edición
                this.categoryBeingEdited = null;

                console.log('Updated Flattened Categories:', this.flattenedCategories);
                console.log('Updated Selected Categories:', this.selectedCategories);
            },
            removeFromHierarchy(categoryId) {
                // Recursivamente buscar y eliminar la categoría de la jerarquía
                const removeCategory = (categories, id) => {
                    for (let i = 0; i < categories.length; i++) {
                        if (categories[i].id === id) {
                            categories.splice(i, 1);
                            return true;
                        }
                        if (categories[i].children) {
                            if (removeCategory(categories[i].children, id)) {
                                return true;
                            }
                        }
                    }
                    return false;
                };

                removeCategory(this.categories, categoryId);
            },
            updateSelectedCategories() {
                const reorder = (categories, level = 0) => {
                    const selectedIds = new Set(this.selectedCategories.map((cat) => cat.id));
                    return categories.reduce((acc, category) => {
                        if (selectedIds.has(category.id)) {
                            const selected = this.selectedCategories.find((cat) => cat.id === category.id);
                            if (selected) {
                                selected.name = category.name; // Actualizar el nombre en las seleccionadas
                            }
                            acc.push({ ...category, level });
                        }
                        if (category.children && category.children.length) {
                            acc.push(...reorder(category.children, level + 1));
                        }
                        return acc;
                    }, []);
                };

                this.selectedCategories = reorder(this.categories);
            },
            
        },
    };
</script>
