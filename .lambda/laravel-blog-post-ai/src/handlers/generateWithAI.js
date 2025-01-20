const { generateAIContent } = require('../services/openAI');

module.exports = async (data) => {

    const { prompt, model, temperature, maxTokens, context } = data;

    try {
        const { content, tokensUsed, fullPromt } = await generateAIContent({ prompt, model, temperature, maxTokens, context });

        return {
            statusCode: 200,
            body: JSON.stringify({
                message: 'Content generated successfully',
                content,
                tokensUsed,
                fullPromt,
            }),
        };
    } catch (error) {
        console.error('Error al generar contenido con AI:', error);
        return {
            statusCode: 500,
            body: JSON.stringify({ error: 'Error al generar contenido con AI', details: error.message }),
        };
    }
};
