const { translateText } = require('../services/googleTranslate');
const { generateAIContent } = require('../services/openAI');

module.exports = async (data) => {
    const { text, targetLanguage, sourceLanguage, rewrite = false } = data;

    try {
        // 1. Traducir texto con Google Translate
        const translatedText = await translateText(text, targetLanguage, sourceLanguage);

        // 2. Si `rewrite` es true, procesar con OpenAI
        let finalText = translatedText;
        if (rewrite) {
            const { content } = await generateAIContent({
                prompt: `
                    Rewrite the following text in a natural and fluent way while preserving its meaning:
                    "${translatedText}"
                `,
                model: 'gpt-4',
                temperature: 0.7,
                maxTokens: 500,
                context: {
                    language: targetLanguage,
                    style: 'natural',
                },
            });
            finalText = content;
        }

        return {
            statusCode: 200,
            body: JSON.stringify({
                message: rewrite ? 'Texto traducido y reformulado con éxito' : 'Texto traducido con éxito',
                translatedText,
                finalText,
            }),
        };
    } catch (error) {
        console.error('Error en la traducción/reformulación:', error);
        return {
            statusCode: 500,
            body: JSON.stringify({ error: 'Error en la traducción/reformulación', details: error.message }),
        };
    }
};
