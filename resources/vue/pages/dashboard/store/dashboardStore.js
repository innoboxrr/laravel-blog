import { defineStore } from 'pinia';

export const useDashboardStore = defineStore('blog-dashboard', {
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
