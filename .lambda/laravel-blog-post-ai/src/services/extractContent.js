const axios = require('axios');
const { JSDOM } = require('jsdom');
const { Readability } = require('@mozilla/readability');

/**
 * Extraer el contenido principal de una URL.
 * @param {string} url - La URL del sitio web.
 * @returns {string|null} - El contenido extraído o null si falla.
 */
const extractContentFromURL = async (url) => {
    try {
        // Obtener el HTML de la página
        const response = await axios.get(url);
        const dom = new JSDOM(response.data, { url });

        // Utilizar Readability para extraer el contenido principal
        const reader = new Readability(dom.window.document);
        const article = reader.parse();

        if (article && article.content) {
            return article.textContent.trim(); // Retorna el texto limpio
        }

        return null;
    } catch (error) {
        console.error('Error al extraer contenido de la URL:', error);
        return null;
    }
};

module.exports = { extractContentFromURL };
