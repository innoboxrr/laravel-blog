/**
 * JSON
 */
/*
    {
        "action": "init",
        "uniqueId": "12345abcde",
        "filename": "example-video.mp4",
        "totalParts": 5
    }
*/
const { handler } = require('../index');
const { generateToken } = require('../src/utils/auth');

// Usuario y token de prueba
const user = { id: 1, role: 'admin' };
const token = generateToken(user);

// Datos del test
const uniqueId = '12345abcde'; // Identificador único proporcionado por el cliente
const filename = 'example-video.mp4';
const totalParts = 3; // Por ejemplo, 3 partes para la subida

// Test de inicialización
const initEvent = {
    headers: {
        Authorization: token,
    },
    body: JSON.stringify({
        action: 'init',
        uniqueId, // Identificador único
        filename, // Nombre del archivo
        totalParts, // Número total de partes
    }),
};

// Test para completar la subida
const completeEvent = {
    headers: {
        Authorization: token,
    },
    body: JSON.stringify({
        action: 'complete',
        uniqueId, // Identificador único
        filename, // Nombre del archivo
        uploadId: 'exampleUploadId123', // Debe obtenerse del resultado del `init`
    }),
};

// Invocar `init` para generar URLs prefirmadas
handler(initEvent)
    .then((initResponse) => {
        console.log('Init Response:', JSON.parse(initResponse.body));

        const { uploadId, presignedUrls } = JSON.parse(initResponse.body);

        console.log('URLs prefirmadas generadas:', presignedUrls);

        // Aquí se puede realizar la lógica de subida de las partes usando las URLs

        // Luego, simular la finalización de la subida
        completeEvent.body = JSON.stringify({
            action: 'complete',
            uniqueId,
            filename,
            uploadId, // Usar el `uploadId` obtenido de la respuesta de `init`
        });

        return handler(completeEvent);
    })
    .then((completeResponse) => {
        console.log('Complete Response:', JSON.parse(completeResponse.body));
    })
    .catch((error) => {
        console.error('Error:', error);
    });
