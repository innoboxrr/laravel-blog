import { defineConfig } from 'vite';
import path from 'path';
import fs from 'fs';
import tailwindcss from 'tailwindcss';

// Ruta a input y salida
const inputPath = path.resolve('assets/css/input.css');
const outputDir = path.resolve('assets/css');
const outputFile = 'main.css';
const fullOutputPath = path.join(outputDir, outputFile);

// Eliminar main.css si ya existe
if (fs.existsSync(fullOutputPath)) {
    fs.unlinkSync(fullOutputPath);
    console.log(`🧹 Eliminado: ${fullOutputPath}`);
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
        emptyOutDir: false,
        outDir: outputDir,
        rollupOptions: {
            input: inputPath,
            output: {
                assetFileNames: () => outputFile,
                entryFileNames: () => outputFile, // por si Vite lo considera entrada JS también
            }
        }
    }
});
