import { createPinia } from 'pinia';
import BlogApp from './components/BlogApp.vue';

const piniaInstance = createPinia();

export default {
    install(app) {
        if (!app.config.globalProperties.$pinia) {
            app.use(piniaInstance);
        }
        app.component('BlogApp', BlogApp);
    },
    piniaInstance,
};