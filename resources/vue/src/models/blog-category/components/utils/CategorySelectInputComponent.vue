<template>
    <div>
        <label :for="id" class="block text-sm font-medium text-gray-700 mb-1">
            {{ label }}
        </label>
        <select
            :id="id"
            v-model="category"
            :class="inputClass">
            <option value="">
                {{ __blog('Without parent category') }}
            </option>
            <option
                v-for="category in flattenedCategories"
                :key="category.id"
                :value="category.id">
                {{ categoryDashIndentation(category.level) + category.name }}
            </option>
        </select>
    </div>
</template>

<script>
    import {
        createFlattenedCategories,
        categoryDashIndentation
    } from '@blogModels/blog-category/helpers/utils';

    export default {
        props: {
            id: {
                type: String,
                default: () => `select-${Math.random().toString(36).substr(2, 9)}`,
            },
            label: {
                type: String,
                required: true,
            },
            categories: {
                type: Array,
                required: true,
            },
            modelValue: {
                type: [String, Number, null],
                default: null,
            },
        },
        computed: {
            category: {
                get() {
                    return this.modelValue;
                },
                set(value) {
                    this.$emit('update:modelValue', value);
                    this.$emit('change', value);
                },
            },
            flattenedCategories() {
                return this.categories && this.categories.length
                    ? createFlattenedCategories(this.categories)
                    : [];
            },
        },
        methods: {
            categoryDashIndentation,
        },
    };
</script>
