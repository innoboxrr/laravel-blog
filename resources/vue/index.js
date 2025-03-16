import BlogApp from './src/BlogApp.vue';
import blogRoutes from './src/routes';
import { createPinia } from 'pinia';
import { TranslatePlugin, TitlePlugin } from './src/plugins';

export const routes = blogRoutes;

export default {
    install(app, options = {}) {
        if (!options.pinia) {
            console.warn('Se recomienda proveer la instancia de Pinia desde la app principal');
            app.use(createPinia());
        } else {
            app.use(options.pinia);
        }
        app.use(TranslatePlugin, options.translateOptions || {});
        app.use(TitlePlugin);
        app.component('BlogApp', BlogApp);
    },
    piniaInstance,
};