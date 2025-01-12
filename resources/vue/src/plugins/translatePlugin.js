import es from '../locales/es.json';
import en from '../locales/en.json';
import { useTranslationsStore } from '../store/translationsStore';

// Traducciones predeterminadas
const defaultTranslations = { es, en };

export default {
    install(app, options = {}) {

        const translationsStore = useTranslationsStore();

        // Cargar locales personalizados si se proporcionan
        const customLocales = options.locales || {};

        // Función para cargar el idioma
        const blogLoadLocale = async (lang) => {
            try {
                // Usar traducciones personalizadas si están disponibles, con respaldo en las predeterminadas
                const translationsForLang = customLocales[lang] || defaultTranslations[lang];

                if (!translationsForLang) {
                    throw new Error(`Idioma no soportado: ${lang}`);
                }

                translationsStore.setLang(lang);
                translationsStore.loadTranslations(translationsForLang);
            } catch (error) {
                console.error(
                    `No se pudieron cargar las traducciones para el idioma: ${lang}`,
                    error
                );
            }
        };

        // Función para traducir cadenas
        const translate = (string) => {
            return translationsStore.translate(string);
        };

        // 1. Registrar como propiedades globales
        app.config.globalProperties.__blog = translate;
        app.config.globalProperties.$blogLoadLocale = blogLoadLocale;

        // 2. Registrar como inyectables
        app.provide('__blog', translate);
        app.provide('$blogLoadLocale', blogLoadLocale);

        // Cargar el idioma por defecto si se proporciona
        if (options.defaultLang) {
            blogLoadLocale(options.defaultLang);
        }
    },
};
