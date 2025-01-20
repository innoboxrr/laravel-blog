/**
 * JSON
 */

/*
    {
        "type": "transcriptWithAI",
        "data": {
            "input": "This is a test text input to be transformed into an article.",
            "model": "gpt-4",
            "temperature": 0.7,
            "maxTokens": 800,
            "context": {
                "language": "English",
                "style": "formal",
                "additionalInstructions": "Structure the content clearly with headings."
            }
        }
    }

    {
        "type": "transcriptWithAI",
        "data": {
            "input": "https://www.elmejorsegurodevida.com/10-consejos-para-contratar-un-seguro-de-vida/",
            "model": "gpt-4",
            "temperature": 0.7,
            "maxTokens": 800,
            "context": {
                "language": "Spanish",
                "style": "informative",
                "additionalInstructions": "Highlight key points clearly."
            }
        }
    }
*/

const { handler } = require('../index');
const { generateToken } = require('../src/utils/auth');

// Usuario y token de prueba
const user = { id: 1, role: 'admin' };
const token = generateToken(user);

// Evento de prueba para texto
const eventText = {
    headers: {
        Authorization: token, // Incluye el token en la cabecera
    },
    body: JSON.stringify({
        type: 'transcriptWithAI',
        data: {
            input: 'This is a test text input to be transformed into an article.',
            model: 'gpt-4',
            temperature: 0.7,
            maxTokens: 800,
            context: {
                language: 'English', // Idioma
                style: 'formal', // Estilo de redacción
                additionalInstructions: 'Structure the content clearly with headings.',
            },
        },
    }),
};

// Evento de prueba para URL
const eventURL = {
    headers: {
        Authorization: token, // Incluye el token en la cabecera
    },
    body: JSON.stringify({
        type: 'transcriptWithAI',
        data: {
            input: 'https://www.elmejorsegurodevida.com/10-consejos-para-contratar-un-seguro-de-vida/',
            model: 'gpt-4',
            temperature: 0.7,
            maxTokens: 800,
            context: {
                language: 'Spanish', // Idioma
                style: 'informative', // Estilo de redacción
                additionalInstructions: 'Highlight key points clearly.',
            },
        },
    }),
};

const context = {};

// Ejecutar pruebas
const testCases = [
    { name: 'Text Input', event: eventText },
    { name: 'URL Input', event: eventURL },
];

testCases.forEach(({ name, event }) => {
    console.log(`Running test case: ${name}`);
    handler(event, context)
        .then((response) => {
            console.log(`Response for ${name}:`, JSON.parse(response.body));
        })
        .catch((error) => {
            console.error(`Error for ${name}:`, error);
        });
});
