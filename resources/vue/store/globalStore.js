import { defineStore } from 'pinia';

export const useGlobalStore = defineStore('blog-global', {
    state: () => ({
        blog: null, // Inicialmente el blog es null
    }),
    actions: {
        setBlog(blogData) {
            this.blog = blogData; // Actualiza el blog
        },
    },
});
