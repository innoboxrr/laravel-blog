import { defineConfig } from 'vite';
import path from 'path';
import fs from 'fs';
import tailwindcss from 'tailwindcss';

const inputPath = path.resolve('assets/css/input.css');
const outputPath = path.resolve('assets/css/main.css');
const buildPath = path.resolve('assets/css/build');

// Elimina main.css si existe
if (fs.existsSync(outputPath)) {
    fs.unlinkSync(outputPath);
    console.log('🧹 Eliminado main.css anterior');
}

export default defineConfig({
    css: {
        postcss: {
            plugins: [
                tailwindcss('./tailwind.config.js'),
            ],
        },
    },
    build: {
        rollupOptions: {
            input: inputPath,
        },
        outDir: buildPath,
        emptyOutDir: true,
    }
});
