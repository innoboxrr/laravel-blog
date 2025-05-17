import fs from 'fs';
import path from 'path';

const buildDir = path.resolve('assets/css/build');
const outputPath = path.resolve('assets/css/main.css');

const cssFile = fs.readdirSync(buildDir).find(f => f.endsWith('.css'));

if (!cssFile) {
    console.error('❌ No se generó CSS.');
    process.exit(1);
}

fs.renameSync(
    path.join(buildDir, cssFile),
    outputPath
);

fs.rmSync(buildDir, { recursive: true });

console.log('✅ main.css generado en assets/css/main.css');
