<template>
	
	<form :id="formId" @submit.prevent="onSubmit">      

        <text-input-component
            :label="__blog('Category name')"
            :placeholder="__blog('Category name')"
            type="text"
            name="name"
            v-model="category.name"
            :custom-class="inputClass"
            validators="required length"
            min_length="3"
            max_length="255"
            required />

        <text-input-component
            :label="__blog('Slug')"
            :placeholder="__blog('Friendly URL')"
            name="slug"
            type="text"
            v-model="category.slug"
            :custom-class="inputClass"
            validators="required length"
            min_length="3"
            max_length="255"
            required />

        <category-select-input-component
            v-if="categories.length > 0"
            :label="__blog('Parent category')"
            :categories="categories"
            v-model="category.parent_id"
            :custom-class="inputClass"
            required />

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

        <button-component
            :custom-class="buttonClass"
            :disabled="disabled"
            :value="buttonText" />
        
    </form>

</template>

<script>
    import { 
        createModel, 
        indexModel 
    } from '@blogModels/blog-category'
    import {
        TextInputComponent,
        TextareaInputComponent,
        ButtonComponent,
    } from 'innoboxrr-form-elements'
    import { slugify } from 'innoboxrr-js-libs/libs/string';
    import JSValidator from 'innoboxrr-js-validator'
    import CategorySelectInputComponent from '@blogModels/blog-category/components/utils/CategorySelectInputComponent.vue'
	
	export default {
        components: {
            TextInputComponent,
            TextareaInputComponent,
            CategorySelectInputComponent,
            ButtonComponent,
        },
        props: {
        	formId: {
        		type: String,
        		default: 'createBlogCategoryForm',
        	},
            blogId: {
                type: Number,
                required: true,
            },
            buttonText: {
                type: String,
                default: 'Create',
            }
        },
        emits: ['submit'],
        data() {
            return {
                categories: [],
                category: {
                    name: '',
                    slug: '',
                    parent_id: '',
                    description: '',
                    blog_id: this.blogId,
                },
                disabled: false,
                JSValidator: undefined,
            }
        },
        mounted() {
            this.fetchData();
            this.JSValidator = new JSValidator(this.formId).init();
        },
        watch: {
            'category.name': function(value) {
                this.category.slug = slugify(value);
            }
        },
        methods: {
            async fetchData() {
                await this.fetchCategories();
            },
            async fetchCategories() {
                this.categories = await indexModel({
                    paginate: 0,
                    only_parents: true,
                    blog_id: this.blogId,
                    load_children: true,
                });
            },
            onSubmit() {
                if(this.JSValidator.status) {
                    this.disabled = true;
                    createModel(this.category).then( res => {
                        this.$emit('submit', res);
                        setTimeout(() => { this.disabled = false; }, 2500);
                    }).catch(error => {
                        this.disabled = false;
                        if(error.response.status == 422)
                            this.JSValidator
                                .appendExternalErrors(error.response.data.errors);
                    });
                } else {
                    this.disabled = false;
                }
            }
        }
	}
</script>