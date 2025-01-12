<template>
    <p>Create Categories</p>
</template>

<script>
    export default {
        name: 'PostsCreate',
        mounted() {
            this.$setTitle(this.__blog('Create Categories'));
        }
    };
</script>