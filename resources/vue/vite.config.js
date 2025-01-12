import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [vue()],
    resolve: {
        alias: {
            '@blog': path.resolve(__dirname, './'),
            '@blogComponents': path.resolve(__dirname, './src/components'),
            '@blogModels': path.resolve(__dirname, './src/models'),
            '@blogPages': path.resolve(__dirname, './src/pages'),
            '@blogStore': path.resolve(__dirname, './src/store'),
        },
    },
});
