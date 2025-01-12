import { defineStore } from 'pinia';

export const useDashboardStore = defineStore('blog-pages-dashboard', {
    state: () => ({
        message: 'Hello from Pinia!',
        count: 0,
    }),
    actions: {
        increment() {
            this.count++;
        },
        updateMessage(newMessage) {
            this.message = newMessage;
        },
    },
});
