const { generateAIContent } = require('../services/openAI');

module.exports = async (data) => {
    const { postContent, context } = data;

    try {
        // Configurar el prompt para mejorar el post
        const prompt = `
            You are an expert editor and writer. Improve the following text by enhancing its grammar, structure, and style.
            
            Input: "${postContent}"
        `;

        // Generar contenido mejorado con OpenAI
        const { content, tokensUsed } = await generateAIContent({
            prompt,
            model: 'gpt-4',
            temperature: 0.7,
            maxTokens: 1000,
            context: {
                language: context?.language || 'English', // Idioma predeterminado: inglés
                style: context?.style || 'professional', // Estilo predeterminado: profesional
                additionalInstructions: context?.additionalInstructions || 'Preserve the original meaning and intent.',
            },
        });

        return {
            statusCode: 200,
            body: JSON.stringify({
                message: 'Post improved successfully',
                improvedPost: content, // Post mejorado como HTML
                tokensUsed,
            }),
        };
    } catch (error) {
        console.error('Error al mejorar el post:', error);
        return {
            statusCode: 500,
            body: JSON.stringify({ error: 'Error al mejorar el post', details: error.message }),
        };
    }
};
