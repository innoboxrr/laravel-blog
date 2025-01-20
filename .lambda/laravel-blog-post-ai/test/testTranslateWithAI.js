/**
 * JSON
 */

/*
    {
        "type": "translateWithAI",
        "data": {
            "text": "Hello, how are you?",
            "targetLanguage": "es",
            "sourceLanguage": "en",
            "rewrite": true
        }
    }
*/
const { handler } = require('../index');
const { generateToken } = require('../src/utils/auth');

// Usuario y token de prueba
const user = { id: 1, role: 'admin' };
const token = generateToken(user);

// Evento de prueba
const event = {
    headers: {
        Authorization: token,
    },
    body: JSON.stringify({
        type: 'translateWithAI',
        data: {
            text: 'Hello, how are you?',
            targetLanguage: 'es',
            sourceLanguage: 'en',
            rewrite: true, // Activar la reformulación con OpenAI
        },
    }),
};

const context = {};

handler(event, context)
    .then((response) => {
        console.log('Response:', JSON.parse(response.body));
    })
    .catch((error) => {
        console.error('Error:', error);
    });
