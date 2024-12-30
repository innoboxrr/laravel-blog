<template>
    <p>Blog app</p>
</template>

<script>
    import { indexModel } from '../api/blog';
    export default {
        name: 'BlogApp',
        props: {
            blogId: {
                type: Number,
                default: 0
            }
        },
        created() {
            this.fetchBlogs();
        },
    }
</script>