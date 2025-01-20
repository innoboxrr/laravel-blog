/**
 * JSON
 */
/*
    {
        "type": "improvePost",
        "data": {
            "postContent": "10. Pedir ayuda. Contratar un seguro de vida es fácil y barato, y se puede hacer por internet, pero lo mejor es pedir asesoramiento a un corredor de seguros experto que trabaje con todas las compañías y aconseje qué es lo mejor en cada caso, cuáles son las coberturas esenciales, cuáles las prescindibles, qué capital es más adecuado para cada economía y dónde están los mejores precios. Y otra cosa, no hay necesidad de seguir año tras año con el mismo seguro ni con la misma compañía. La vida va cambiando, y las necesidades también. Firmar un seguro de vida y olvidarse, pagar sin mirar el recibo, aunque sea bajo, es un error. Se aconseja ir adaptando el capital y las coberturas a las necesidades del momento. Siempre que haya cambios significativos en la vida que repercutan en el ámbito económico, familiar y personal, conviene ajustar la póliza, en más o en menos. Y también estar atentos a las nuevas ofertas. Si quieres asesoramiento, llámanos. Es gratis.",
            "context": {
                "language": "Spanish",
                "style": "formal",
                "additionalInstructions": "Add appropriate HTML tags for headings and paragraphs. not the full HTML document, just the content."
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
        Authorization: token,
    },
    body: JSON.stringify({
        type: 'improvePost',
        data: {
            postContent: '10. Pedir ayuda. Contratar un seguro de vida es fácil y barato, y se puede hacer por internet, pero lo mejor es pedir asesoramiento a un corredor de seguros experto que trabaje con todas las compañías y aconseje qué es lo mejor en cada caso, cuáles son las coberturas esenciales, cuáles las prescindibles, qué capital es más adecuado para cada economía y dónde están los mejores precios. Y otra cosa, no hay necesidad de seguir año tras año con el mismo seguro ni con la misma compañía. La vida va cambiando, y las necesidades también. Firmar un seguro de vida y olvidarse, pagar sin mirar el recibo, aunque sea bajo, es un error. Se aconseja ir adaptando el capital y las coberturas a las necesidades del momento. Siempre que haya cambios significativos en la vida que repercutan en el ámbito económico, familiar y personal, conviene ajustar la póliza, en más o en menos. Y también estar atentos a las nuevas ofertas. Si quieres asesoramiento, llámanos. Es gratis.',
            context: {
                language: 'Spanish',
                style: 'formal',
                additionalInstructions: 'Add appropriate HTML tags for headings and paragraphs. not the full HTML document, just the content.',
            },
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