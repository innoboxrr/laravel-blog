const fs = require('fs');
const archiver = require('archiver');
const { Lambda } = require('aws-sdk');
require('dotenv').config();

const packageAndDeploy = async () => {
    const functionName = process.env.LAMBDA_FUNCTION_NAME;
    if (!functionName) {
        console.error('Error: Define LAMBDA_FUNCTION_NAME in your .env file');
        return;
    }

    const zipFileName = `${functionName}.zip`;

    // Crear archivo ZIP
    console.log('Empaquetando archivos en un ZIP...');
    const output = fs.createWriteStream(zipFileName);
    const archive = archiver('zip', { zlib: { level: 9 } });

    output.on('close', () => {
        console.log(`Archivo ZIP creado: ${zipFileName} (${archive.pointer()} bytes)`);
        deployToLambda(zipFileName);
    });

    archive.on('error', (err) => {
        throw err;
    });

    archive.pipe(output);
    archive.directory('.', false); // Agregar todos los archivos en el directorio actual
    archive.finalize();
};

// Subir el ZIP a AWS Lambda
const deployToLambda = async (zipFileName) => {
    const functionName = process.env.LAMBDA_FUNCTION_NAME;

    console.log('Subiendo el ZIP a AWS Lambda...');
    const lambda = new Lambda({
        region: process.env.EAWS_REGION,
        accessKeyId: process.env.EAWS_ACCESS_KEY_ID,
        secretAccessKey: process.env.EAWS_SECRET_ACCESS_KEY,
    });

    const zipBuffer = fs.readFileSync(zipFileName);

    try {
        await lambda
            .updateFunctionCode({
                FunctionName: functionName,
                ZipFile: zipBuffer,
            })
            .promise();
        console.log(`Despliegue exitoso: ${functionName}`);
    } catch (err) {
        console.error('Error al desplegar la función Lambda:', err.message);
    }
};

// Ejecutar el script
packageAndDeploy();
