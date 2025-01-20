const { extractContentFromURL } = require('../services/extractContent');
const { generateAIContent } = require('../services/openAI');

module.exports = async (data) => {
    const { input, model, temperature, maxTokens, context } = data;

    try {
        let content = input; // Por defecto, el input es el contenido base
        let isURL = false;

        // Verificar si el input es una URL
        if (input.startsWith('http://') || input.startsWith('https://')) {
            isURL = true;

            // Extraer contenido de la URL
            const extractedContent = await extractContentFromURL(input);

            if (!extractedContent) {
                throw new Error('No se pudo extraer el contenido de la URL proporcionada.');
            }

            content = extractedContent; // El contenido extraído será el prompt base
        }

        // Generar contenido con OpenAI a partir del texto o contenido extraído
        const { content: generatedContent, tokensUsed, fullPromt } = await generateAIContent({
            prompt: `Transform the following content into a well-structured article:\n\n${content}`,
            model,
            temperature,
            maxTokens,
            context,
        });

        return {
            statusCode: 200,
            body: JSON.stringify({
                message: 'Transcript processed successfully',
                sourceType: isURL ? 'url' : 'text',
                sourceContent: content,
                generatedContent,
                tokensUsed,
                fullPromt,
            }),
        };
    } catch (error) {
        console.error('Error al procesar transcripción con AI:', error);
        return {
            statusCode: 500,
            body: JSON.stringify({ error: 'Error al procesar transcripción con AI', details: error.message }),
        };
    }
};
