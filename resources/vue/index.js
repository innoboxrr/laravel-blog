import BlogApp from './src/BlogApp.vue';
import blogRoutes from './src/routes';
import { createPinia } from 'pinia';
import { TranslatePlugin, TitlePlugin } from './src/plugins';

const piniaInstance = createPinia();
export const routes = blogRoutes;

export default {
    install(app, options = {}) {
        if (!app.config.globalProperties.$pinia) {
            app.use(piniaInstance);
        }

        app.use(TranslatePlugin, options.translateOptions || {});
        app.use(TitlePlugin);

        app.component('BlogApp', BlogApp);
    },
    piniaInstance,
};