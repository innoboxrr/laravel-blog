# Blog Package with Translation Support

This README explains the implementation and usage of the translation functionality in the Blog Package. The package supports:

1. Dynamic locale loading.
2. Default and custom translations.
3. Component-based language switching.

---

## Installation

Install the package and its dependencies:

```bash
npm install your-blog-package pinia
```

---

## Initialization

### Main Package Initialization

Create the `BlogPackage` as the main entry point for the package:

```javascript
import { createPinia } from 'pinia';
import BlogApp from './components/BlogApp.vue';
import BlogPlugin from './blogPlugin';

const piniaInstance = createPinia();

export default {
    install(app, options = {}) {
        if (!app.config.globalProperties.$pinia) {
            app.use(piniaInstance);
        }

        app.use(BlogPlugin, options);

        app.component('BlogApp', BlogApp);
    },
    piniaInstance,
};
```

### Translation Plugin

The `BlogPlugin` manages translations:

```javascript
import { useTranslationsStore } from './store/translationsStore';

export default {
    install(app, options = {}) {
        const translationsStore = useTranslationsStore();

        // Load custom locales if provided
        const customLocales = options.locales || {};

        // Function to load locale
        const blogLoadLocale = async (lang) => {
            try {
                const translations = customLocales[lang] || (await import(`./locales/${lang}.json`)).default;
                translationsStore.setLang(lang);
                translationsStore.loadTranslations(translations);
            } catch (error) {
                console.error(`Failed to load translations for language: ${lang}`, error);
            }
        };

        // Register a global translation method
        app.config.globalProperties.__blog = (string) => {
            return translationsStore.translate(string);
        };

        // Make `blogLoadLocale` globally available
        app.config.globalProperties.$blogLoadLocale = blogLoadLocale;

        // Load default language if provided
        if (options.defaultLang) {
            blogLoadLocale(options.defaultLang);
        }
    },
};
```

### Translation Store

The Pinia store manages the current language and translations:

```javascript
import { defineStore } from 'pinia';

export const useTranslationsStore = defineStore('translations', {
    state: () => ({
        currentLang: 'en', // Default language
        translations: {}, // Loaded translations
    }),
    actions: {
        setLang(lang) {
            this.currentLang = lang;
        },
        loadTranslations(translations) {
            this.translations = translations;
        },
        translate(string) {
            return this.translations[string] || string; // Return the translation or the original string
        },
    },
});
```

---

## Blog Component with Language Support

The `BlogDashboardView` component uses the translation functionality dynamically.

### Component Code

```javascript
<script>
import { watch, toRefs, getCurrentInstance } from 'vue';
import { useGlobalStore } from '@blogStore/globalStore';
import { useTranslationsStore } from '@blogStore/translationsStore';

export default {
    name: 'BlogDashboardView',
    props: {
        blog: {
            type: Object,
            required: true, // Blog data from the parent component
        },
        lang: {
            type: String,
            default: 'en',
        },
    },
    setup(props) {
        // Import stores
        const globalStore = useGlobalStore();
        const translationsStore = useTranslationsStore();

        // Access global properties
        const instance = getCurrentInstance();
        const $blogLoadLocale = instance?.appContext.config.globalProperties.$blogLoadLocale;

        // Reference reactive global store data
        const { navigation } = toRefs(globalStore);

        // Initialize blog
        const initializeBlog = () => {
            globalStore.setBlog(props.blog);
        };

        // Initialize locale
        const initializeLocale = () => {
            if (translationsStore.currentLang !== props.lang) {
                $blogLoadLocale(props.lang);
            }
        };

        // Setup reactive watchers
        const setupWatchers = () => {
            watch(
                () => props.blog,
                (newBlog) => {
                    globalStore.setBlog(newBlog);
                },
                { immediate: true }
            );

            watch(
                () => props.lang,
                (newLang) => {
                    $blogLoadLocale(newLang);
                },
                { immediate: true }
            );
        };

        // Initialize component
        initializeBlog();
        initializeLocale();
        setupWatchers();

        return {
            navigation,
        };
    },
};
</script>
```

### Usage in Templates

```html
<BlogApp :blog="blog" lang="es" />
```

---

## Application Setup

### Integrating the Blog Package

```javascript
import { createApp } from 'vue';
import BlogPackage from 'path/to/your/package';

const customLocales = {
    es: {
        Hello: 'Hola personalizado',
        'Create Blog': 'Crear Blog personalizado',
    },
};

const app = createApp(App);

app.use(BlogPackage, {
    defaultLang: 'es', // Default language
    locales: customLocales, // Custom translations
});

app.mount('#app');
```

---

## Features

- **Dynamic Translation Loading**: Automatically loads translation files based on the `lang` prop.
- **Custom Locales**: Allows passing custom translations via the `options.locales` parameter.
- **Reactive Language Switching**: Updates translations dynamically when the language changes.
- **Global Translation Method**: Access translations using `__blog('String')` in any component.

---

## Example Folder Structure

```
/src
  /components
    BlogApp.vue
  /store
    translationsStore.js
  /locales
    en.json
    es.json
  blogPlugin.js
  index.js
```

