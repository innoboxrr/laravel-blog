# InnoboxRR Vue Blog

`innoboxrr-vue-blog` es un paquete frontend desarrollado con Vue 3 y Pinia que proporciona una solución completa para la gestión de blogs, incluyendo administración de posts, categorías, etiquetas, vistas de búsqueda, suscripciones, y configuración SEO. Este paquete está diseñado para integrarse con aplicaciones de Laravel usando `laravel-blog` como backend.

---

## Características

### **Vistas Administrativas**

1. **BlogDashboard**: Panel principal para la administración del blog.
2. **BlogSettingsView**: Configuración general del blog (SEO, opciones avanzadas).
3. **BlogPostDataTable**: Tabla interactiva para la gestión de posts.
4. **BlogCategoryModal**:
    - BlogCategoryCreateForm
    - BlogCategoryEditForm
5. **BlogPostModal**:
    - BlogPostCreateForm
        - BlogTagAssignment
    - BlogPostEditForm
        - BlogTagAssignment
    - BlogPostPreview

### **Vistas del Sitio**

1. **HomePageView**: Vista principal del blog para los visitantes.
2. **SearchView**: Página de búsqueda con resultados basados en entradas del blog.
3. **PostView**: Detalle de un post individual.
4. **RSSFeed**: Generación de feeds RSS para el blog.
5. **SubscriptionModal**: Modal para gestionar suscripciones de usuarios.

---

## Instalación

### 1. Instalar el Paquete

Asegúrate de tener el paquete instalado desde npm o enlazado localmente:
```bash
npm install innoboxrr-vue-blog
```

### 2. Registrar el Paquete en Bootstrap

Agrega `BlogApp` al bootstrap de tu aplicación:

```javascript
import { createApp } from 'vue';
import BlogApp from 'innoboxrr-vue-blog';

const app = createApp(App);
app.use(BlogApp);
```

### 2.1 Traducciones

Puedes añadir traducciones personalizadas de la siguinte manera
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
    translateOptions: {
        defaultLang: 'es', // Idioma por defecto
        locales: customLocales, // Locales personalizados
    }
});

app.mount('#app');
```


### 3. Configurar la Vista Principal

Crea una vista en tu aplicación principal donde quieras mostrar el blog:

**Archivo: `BlogView.vue`**
```vue
<template>
    <BlogApp />
</template>

<script>
export default {
    name: 'BlogView',
};
</script>
```

### 4. Registrar Rutas

Incluye las rutas del paquete como hijos de una ruta principal:

**Archivo: `routes/index.js`**
```javascript
import blogRoutes from 'innoboxrr-vue-blog/routes';

export default [
    {
        path: '/blog',
        name: 'AdminBlog',
        component: () => import('./../views/BlogView.vue'),
        meta: {
            title: 'Blog',
        },
        children: [
            ...blogRoutes,
        ],
    },
];
```

### 5. Configurar Alias en `vite.config.js`

Añade los alias para facilitar las importaciones de modelos, páginas y tiendas del paquete:

**Archivo: `vite.config.js`**
```javascript
import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [vue()],
    resolve: {
        alias: {
            '@blog': path.resolve(__dirname, 'node_modules/innoboxrr-vue-blog/'),
            '@blogComponents': path.resolve(__dirname, 'node_modules/innoboxrr-vue-blog/src/components'),
            '@blogModels': path.resolve(__dirname, 'node_modules/innoboxrr-vue-blog/src/models'),
            '@blogPages': path.resolve(__dirname, 'node_modules/innoboxrr-vue-blog/src/pages'),
            '@blogStore': path.resolve(__dirname, 'node_modules/innoboxrr-vue-blog/src/store'),
        },
    },
});
```

### 6. Configurar tailwind.config.js

Añade los contenidos que tienen que ser analizados por tailwind

```javascript
/** @type {import('tailwindcss').Config} */
const {addDynamicIconSelectors} = require('@iconify/tailwind');
const colors = require('tailwindcss/colors');
const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
  content: [
    // ...
    "./node_modules/innoboxrr-vue-blog/**/*.vue",
    "./node_modules/innoboxrr-vue-blog/**/*.js",
    "./node_modules/innoboxrr-vue-blog/**/*.blade.php",
    // ...
  ],
  darkMode: "class",
  theme: {/*...*/},
  plugins: [/*...*/],
}

```

---

## Uso del Paquete

### Store Global con Pinia
`innoboxrr-vue-blog` utiliza una tienda global para manejar el estado del blog. El estado inicial del blog debe pasarse como `prop` al componente `BlogApp` y sincronizarse con la tienda global.

**Ejemplo:**
```javascript
import { useGlobalStore } from '@blogStore/globalStore';
const globalStore = useGlobalStore();
globalStore.setBlog(blogData);
```

### Acceso al Estado en Componentes
Las propiedades del blog almacenadas en la tienda global son accesibles en cualquier componente mediante `useGlobalStore`.

**Ejemplo:**
```javascript
import { useGlobalStore } from '@blogStore/globalStore';

export default {
    setup() {
        const globalStore = useGlobalStore();
        return {
            blog: globalStore.blog,
        };
    },
};
```

---

## Desarrollo Local

### Crear Enlace Simbólico
Si estás desarrollando el paquete y quieres probarlo localmente en una aplicación principal:

1. Crea un enlace simbólico desde el paquete:
   ```bash
   cd innoboxrr-vue-blog
   npm link
   ```

2. Usa el enlace en la aplicación principal:
   ```bash
   cd tu-aplicacion
   npm link innoboxrr-vue-blog
   ```

3. Reinicia el servidor de desarrollo para aplicar los cambios.

---

## Notas Adicionales

1. **Configuración SEO:**
   Usa `BlogSettingsView` para configurar el SEO del blog.

2. **Integración con Laravel:**
   Este paquete está diseñado para funcionar junto con `laravel-blog`. Configura las APIs necesarias en tu backend para la funcionalidad completa.

3. **Rendimiento:**
   Aprovecha las optimizaciones de Pinia y Vue 3 para garantizar un rendimiento eficiente en toda la aplicación.

---

## Contribución
Si deseas contribuir al desarrollo de este paquete, sigue los pasos para desarrollo local y envía tus pull requests en el repositorio oficial.

---

## Licencia
`innoboxrr-vue-blog` está licenciado bajo [MIT License](LICENSE).
