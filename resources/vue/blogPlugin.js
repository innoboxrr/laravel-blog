import { useTranslationsStore } from './store/translationsStore';

export default {
    install(app, options = {}) {

        const translationsStore = useTranslationsStore();

        // Cargar locales personalizados si se proporcionan
        const customLocales = options.locales || {};

        // Función para cargar el idioma
        const blogLoadLocale = async (lang) => {
            try {
                const translations = customLocales[lang] || (await import(`./locales/${lang}.json`)).default;
                translationsStore.setLang(lang); 
                translationsStore.loadTranslations(translations);
            } catch (error) {
                console.error(`No se pudieron cargar las traducciones para el idioma: ${lang}`, error);
            }
        };

        // Registrar un método global para traducir
        app.config.globalProperties.__blog = (string) => {
            return translationsStore.translate(string);
        };

        // Hacer que la función `blogLoadLocale` esté disponible globalmente
        app.config.globalProperties.$blogLoadLocale = blogLoadLocale;

        // Cargar el idioma por defecto si se proporciona
        if (options.defaultLang) {
            blogLoadLocale(options.defaultLang);
        }
    },
};
