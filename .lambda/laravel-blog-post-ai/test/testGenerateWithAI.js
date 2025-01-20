/**
 * JSON
 */

/*
    {
        "type": "generateWithAI",
        "data": {
            "prompt": "Explain the theory of relativity in simple terms.",
            "model": "gpt-4",
            "temperature": 0.7,
            "maxTokens": 150,
            "context": {
                "language": "Spanish",
                "style": "formal",
                "additionalInstructions": "Focus on examples for beginners."
            }
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
        Authorization: token, // Incluye el token en la cabecera
    },
    body: JSON.stringify({
        type: 'generateWithAI',
        data: {
            prompt: 'Explain the theory of relativity in simple terms.',
            model: 'gpt-4',
            temperature: 0.7,
            maxTokens: 150,
            context: {
                language: 'Spanish', // Idioma
                style: 'formal', // Estilo de redacción like: 'casual', 'formal', 'academic'
                additionalInstructions: 'Focus on examples for beginners.', 
            }
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
