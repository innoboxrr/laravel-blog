import { defineStore } from 'pinia';

export const useBlogStore = defineStore('blog', {
    state: () => ({
        posts: [],
        currentPost: null,
    }),
    actions: {
        setPosts(posts) {
            this.posts = posts;
        },
        setCurrentPost(post) {
            this.currentPost = post;
        },
        async fetchPosts() {
            // Simula una API
            this.posts = [
                { id: 1, title: 'Primer Post' },
                { id: 2, title: 'Segundo Post' },
            ];
        },
    },
});
