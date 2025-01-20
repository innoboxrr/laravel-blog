const OpenAI = require('openai');

// Cargar dotenv solo en entornos locales
if (process.env.NODE_ENV !== 'production') {
    require('dotenv').config();
}

// Configuración del cliente OpenAI
const client = new OpenAI({
    apiKey: process.env.OPENAI_API_KEY, // Clave API desde .env
});

/**
 * Generar contenido con IA
 * @param {Object} params - Parámetros de generación de contenido
 * @param {string} params.prompt - El prompt principal
 * @param {string} params.model - El modelo de OpenAI a utilizar (por defecto: gpt-4)
 * @param {number} params.temperature - La temperatura para la creatividad (por defecto: 0.7)
 * @param {number} params.maxTokens - El máximo de tokens permitidos (por defecto: 500)
 * @param {Object} params.context - Contexto adicional para personalizar el prompt (idioma, estilo, etc.)
 * @returns {Object} - Contenido generado y uso de tokens
 */
const generateAIContent = async ({
    prompt,
    model = 'gpt-4',
    temperature = 0.7,
    maxTokens = 500,
    context = {}, // Contexto adicional
}) => {
    try {
        // Construir el prompt con el contexto adicional
        let fullPrompt = prompt;

        if (context.language) {
            fullPrompt = `Please respond in ${context.language}. ` + fullPrompt;
        }

        if (context.style) {
            fullPrompt += ` Write in a ${context.style} style.`;
        }

        if (context.audience) {
            fullPrompt += ` The response should be tailored for ${context.audience}.`;
        }

        if (context.tone) {
            fullPrompt += ` Use a ${context.tone} tone.`;
        }

        if (context.restrictions) {
            fullPrompt += ` Please adhere to these restrictions: ${context.restrictions}.`;
        }

        if (context.keywords) {
            fullPrompt += ` Ensure to include the following keywords: ${context.keywords.join(', ')}.`;
        }

        if (context.useHtml) {
            fullPrompt += ' Ensure the output is formatted as HTML with proper headings, paragraphs, and bullet points (if applicable). Do not add any comments or explanations outside the HTML content.';
        }
        

        let systemPromt = (context.additionalInstructions) ? ` ${context.additionalInstructions}` : 'You are a technical expert assistant. You provide detailed, accurate, and technical answers.';

        const stream = await client.chat.completions.create({
            model,
            messages: [
                { role: 'system', content: systemPromt },
                { role: 'user', content: fullPrompt }
            ],
            temperature,
            max_tokens: maxTokens,
            stream: true,
        });

        let responseContent = '';
        let totalTokens = 0;

        // Procesar el flujo de respuesta
        for await (const chunk of stream) {

            const delta = chunk.choices[0]?.delta?.content || '';
            responseContent += delta;

            // Contar tokens empleados si están disponibles
            totalTokens += chunk.usage?.total_tokens || 0;
        }

        return {
            content: responseContent.trim(),
            tokensUsed: totalTokens,
            fullPromt: fullPrompt,
        };
    } catch (error) {
        console.error('Error al llamar a la API de OpenAI:', error);
        throw new Error('Error al generar contenido con OpenAI');
    }
};

module.exports = { generateAIContent };
