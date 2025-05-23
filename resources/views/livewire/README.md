### README.md para la estructura de temas

```markdown
# Estructura de Temas para el Blog

Este directorio contiene los temas disponibles para el blog. Cada tema es un módulo independiente que define su propio diseño, estilos, componentes y vistas. Esto permite a los usuarios personalizar la apariencia de su blog de manera modular y flexible.

---

## Estructura de Directorios

Cada tema sigue la siguiente estructura:

```
themes
    {theme}
        /assets
            /css
            /fonts
            /images
            /js
        /components
            blog-post-card.blade.php
            post-about-author.blade.php
            related-posts.bñade.php
            share-post.blade.php
            subscribe-component.blade.php
        /config
            LayoutData.php
        /layout
            /includes
                // ...
            app.blade.php
        /node_modules
            // ...
        /views
            blog-category-view.blade.php
            blog-contact-view.blade.php
            blog-index-view.blade.php
            blog-login-view.blade.php
            blog-post-view.blade.php
            blog-tag-view.blade.php
        .gitignore
        package.json
        tailwind.config.js
        vite.config.js
```

### Descripción de las carpetas

1. **`components/`**:
   - Contiene los componentes Livewire personalizados del tema.
   - Ejemplo: `subscribe-component.blade.php`.

2. **`layout/`**:
   - Contiene el layout principal del tema.
   - Ejemplo: `app.blade.php`.

3. **`views/`**:
   - Contiene las vistas específicas del tema para páginas como la lista de posts y el detalle de un post.
   - Ejemplo: `blog-index-view.blade.php`.

4. **`theme.json`**:
   - Archivo de configuración del tema. Contiene información como colores, fuentes y otros ajustes personalizables.

---

## Configuración de un Tema

### 1. Crear un nuevo tema
Para agregar un nuevo tema:
1. Crea una nueva carpeta dentro de `themes/`.
2. Copia la estructura de un tema existente (`default`) como base.
3. Modifica las vistas, layout y componentes según los requerimientos del diseño.

### 2. Archivo `theme.json`
Cada tema debe tener un archivo `theme.json` para definir su configuración. Ejemplo:

```json
{
    "name": "Default Theme",
    "primary_color": "#3490dc",
    "secondary_color": "#ffed4a",
    "font_family": "Arial, sans-serif"
}
```

### 3. Usar un tema específico
El tema se selecciona dinámicamente desde la configuración del usuario o blog. El layout, las vistas y los componentes serán cargados desde el tema activo.

---

## Ejemplo de Implementación

### Layout dinámico
El layout principal del tema define la estructura básica de la página:

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('themes/' . $activeTheme . '/css/styles.css') }}">
</head>
<body>
    <header>
        <h1>Bienvenido a {{ config('app.name') }}</h1>
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}</p>
    </footer>
    <script src="{{ asset('themes/' . $activeTheme . '/js/scripts.js') }}"></script>
</body>
</html>
```

### Vista de ejemplo
Una vista para la página principal del blog dentro de `views/blog-index-view.blade.php`:

```blade
@extends('themes.' . $activeTheme . '.layout.app')

@section('content')
<div>
    <h2>Lista de Posts</h2>
    <ul>
        @foreach ($posts as $post)
            <li>
                <a href="{{ route('blog.post', $post->slug) }}">{{ $post->title }}</a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
```

---

## Agregar un Tema Nuevo

1. Copia la carpeta de un tema existente (por ejemplo, `default`) como base.
2. Renombra la carpeta con el nombre de tu nuevo tema, por ejemplo, `modern`.
3. Personaliza las vistas, estilos y configuraciones dentro de la nueva carpeta.
4. Agrega un nuevo archivo `theme.json` con las configuraciones del tema.

Ejemplo:
```json
{
    "name": "Modern Theme",
    "primary_color": "#333",
    "secondary_color": "#555",
    "font_family": "Helvetica, sans-serif"
}
```

---

## Consideraciones

1. **Modularidad**: Cada tema es independiente y puede ser modificado sin afectar a otros temas.
2. **Escalabilidad**: Es fácil agregar nuevos temas copiando y ajustando la estructura existente.
3. **Flexibilidad**: Los usuarios pueden cambiar dinámicamente el tema desde la configuración de su blog.

---

¡Empieza a personalizar tus temas y ofrece a los usuarios un blog que refleje su estilo y marca!
```