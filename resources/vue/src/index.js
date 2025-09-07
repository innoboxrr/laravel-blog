import blogRoutes from './routes';
import { TranslatePlugin, TitlePlugin } from './plugins';

export const routes = blogRoutes;

export default {
    install(app, options = {}) {
        app.use(TranslatePlugin, options.translateOptions || {});
        app.use(TitlePlugin);
    }
};