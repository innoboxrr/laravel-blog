import { createPinia } from 'pinia';
import BlogApp from './components/BlogApp.vue';
import BlogPlugin from './blogPlugin';

const piniaInstance = createPinia();

export default {
    install(app, options = {}) {
        if (!app.config.globalProperties.$pinia) {
            app.use(piniaInstance);
        }

        app.use(BlogPlugin, options);

        app.component('BlogApp', BlogApp);
    },
    piniaInstance,
};