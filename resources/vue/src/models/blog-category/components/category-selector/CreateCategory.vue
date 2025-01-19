<template>
    <div>
        <div class="flex justify-end mb-3">
            <button
                @click="showAddForm = !showAddForm"
                class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-md shadow hover:bg-blue-700">
                <i :class="showAddForm ? 'fas fa-times' : 'fas fa-plus'"></i>
                <span>{{ showAddForm ? 'Cerrar' : 'Añadir Categoría' }}</span>
            </button>
        </div>
        <div v-if="showAddForm" class="space-y-4 mb-6">
            <blog-category-create-form 
                :blog-id="blogId"
                @submit="categoryCreateFormSubmit" />
        </div>
    </div>
</template>

<script>
    import { categoryDashIndentation} from '@blogModels/blog-category/helpers/utils';
    import BlogCategoryCreateForm from '@blogModels/blog-category/forms/CreateForm.vue';
    export default {
        components: {
            BlogCategoryCreateForm,
        },
        props: {
            blogId: {
                type: Number,
                required: true,
            },
        },
        emits: ['showAddForm', 'categoryCreated'],
        data() {
            return {
                showAddForm: false,
                category: {
                    name: '',
                    parent_id: null,
                }
            }
        },
        watch: {
            showAddForm(value) {
                this.$emit('showAddForm', value);
            }
        },
        methods: {
            categoryDashIndentation,
            categoryCreateFormSubmit(data) {
                this.$emit('categoryCreated', data);
                this.showAddForm = false;
            },
        }
    }
</script>