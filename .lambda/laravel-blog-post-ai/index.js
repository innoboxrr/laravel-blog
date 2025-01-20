require('dotenv').config();

const { validateToken } = require('./src/utils/auth');

const improvePost = require('./src/handlers/improvePost');
const generateWithAI = require('./src/handlers/generateWithAI');
const translateWithAI = require('./src/handlers/translateWithAI');
const transcriptWithAI = require('./src/handlers/transcriptWithAI');
const videoToTextAI = require('./src/handlers/videoToTextAI');
const videoUploadHandler = require('./src/handlers/videoUploadHandler');

exports.handler = async (event) => {
    const authorizationHeader = event.headers?.Authorization || event.headers?.authorization;
    const user = validateToken(authorizationHeader);

    const { type, data, errorResponse } = getData(event);

    // Si hubo un error al procesar el body
    if (errorResponse) {
        return errorResponse;
    }

    try {
        switch (type) {
            case 'improvePost':
                return await improvePost(data);
            case 'generateWithAI':
                return await generateWithAI(data);
            case 'translateWithAI':
                return await translateWithAI(data);
            case 'transcriptWithAI':
                return await transcriptWithAI(data);
            case 'videoToTextAI':
                return await videoToTextAI(data);
            case 'videoUpload':
                return await videoUploadHandler(data);
            default:
                return {
                    statusCode: 400,
                    body: JSON.stringify({ error: 'Invalid action type' }),
                };
        }
    } catch (error) {
        console.error('Error:', error);
        return {
            statusCode: 500,
            body: JSON.stringify({ error: 'Internal server error', details: error.message }),
        };
    }
};

const getData = (event) => {
    let body;

    if (typeof event.body === 'string') {
        try {
            body = JSON.parse(event.body);
        } catch (err) {
            console.error('Error al parsear event.body:', err.message);
            return {
                errorResponse: {
                    statusCode: 400,
                    body: JSON.stringify({ error: 'Invalid JSON format in body' }),
                },
            };
        }
    } else if (typeof event.body === 'object') {
        body = event.body; // Ya es un objeto
    } else {
        return {
            errorResponse: {
                statusCode: 400,
                body: JSON.stringify({ error: 'Invalid body format' }),
            },
        };
    }

    const { type, data } = body;
    return { type, data }; // Devolver los valores correctamente
};
