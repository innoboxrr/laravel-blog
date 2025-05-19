<template>
    <div v-if="blog" class="flex justify-center items-center">
        <div class="w-full">
            <div class="card bg-white dark:bg-slate-600 border px-8 pt-6 pb-8 dark:border-slate-800">
                <blog-edit-form
                    style="min-height: calc(100vh - 10rem)"
                    class="flex max-w-5xl m-auto"
                    :blog-id="blog.id"
                    @submit="submit" />
            </div>
        </div>
    </div>
</template>

<script>
    import { toRefs } from 'vue';
    import { useGlobalStore } from '@blogStore/globalStore'; 
    import BlogEditForm from '@blogModels/blog/forms/EditForm.vue';
    export default {
        components: {
            BlogEditForm,
        },
        name: 'BlogDashboardView',
        setup() {
            const globalStore = useGlobalStore();
            const { blog } = toRefs(globalStore);

            return {
                blog,
            };
        },
    };
</script>