const axios = require('axios');

// Cargar dotenv solo en entornos locales
if (process.env.NODE_ENV !== 'production') {
    require('dotenv').config();
}

// Endpoint de Google Translate
const GOOGLE_TRANSLATE_API_URL = 'https://translation.googleapis.com/language/translate/v2';

/**
 * Traduce texto utilizando la API de Google Translate
 * @param {string} text - Texto a traducir
 * @param {string} targetLanguage - Idioma de destino (e.g., 'es', 'fr')
 * @param {string} sourceLanguage - Idioma de origen (opcional, auto-detección si no se especifica)
 * @returns {string} - Texto traducido
 */
const translateText = async (text, targetLanguage, sourceLanguage = '') => {
    try {
        const response = await axios.post(
            GOOGLE_TRANSLATE_API_URL,
            null,
            {
                params: {
                    q: text,
                    target: targetLanguage,
                    source: sourceLanguage,
                    key: process.env.GOOGLE_TRANSLATE_API_KEY,
                },
            }
        );

        const translatedText = response.data.data.translations[0].translatedText;
        return translatedText;
    } catch (error) {
        console.error('Error en la traducción con Google Translate:', error);
        throw new Error('Error en la traducción con Google Translate');
    }
};

module.exports = { translateText };
