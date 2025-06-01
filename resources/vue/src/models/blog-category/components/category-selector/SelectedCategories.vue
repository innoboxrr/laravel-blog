<template>
    <div>
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            {{ __blog('Selected Categories') }}
        </h3>
        <ul class="space-y-2">
            <li
                v-for="category in selectedCategories"
                :key="category.id"
                class="flex items-center gap-2 text-sm font-medium text-gray-800"
                :style="{ paddingLeft: `${category.level * 1.5}rem` }">
                <i class="fas fa-tag text-blue-600"></i>
                <span>{{ category.name }}</span>
                <div class="ml-auto flex gap-2">
                    <button
                        @click="editCategory(category)"
                        class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button
                        @click="removeCategory(category.id)"
                        class="text-red-600 hover:text-red-800 text-sm font-semibold">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    import { addLevelsFromParentRelations } from '@blogModels/blog-category/helpers/utils';
    
    export default {
        props: {
            categories: {
                type: Array,
                default: () => [],
            },
            preselected: {
                type: Array,
                default: () => [],
            },
        },
        data() {
            return {
                selectedCategories: this.setSelectedCategories(),
            };
        },
        methods: {
            setSelectedCategories() {
                if (this.preselected.length === 0) return [];

                const enriched = addLevelsFromParentRelations([...this.preselected, ...this.categories]);
                const enrichedMap = new Map(enriched.map(cat => [cat.id, cat]));

                return this.preselected.map(cat => enrichedMap.get(cat.id));
            },
            editCategory(category) {
                this.$emit('editCategory', category);
            },
            removeCategory(categoryId) {
                this.$emit('removeCategory', categoryId);
            }
        },
    }
</script>