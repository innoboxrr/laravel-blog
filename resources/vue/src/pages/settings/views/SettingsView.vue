<template>
    <div class="min-h-full">
        <p>Settings View</p>
    </div>
</template>

<script>
    import { toRefs } from 'vue';
    import { useGlobalStore } from '@blogStore/globalStore'; 
    export default {
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