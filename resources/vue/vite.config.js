import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [vue()],
    resolve: {
        alias: {
            '@blog': path.resolve(__dirname, './'),
            '@blogModels': path.resolve(__dirname, './models'),
            '@blogPages': path.resolve(__dirname, './pages'),
            '@blogStore': path.resolve(__dirname, './store'),
        },
    },
});
