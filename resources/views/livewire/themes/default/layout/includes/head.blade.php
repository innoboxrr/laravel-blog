@php
    // Normaliza datos
    $title            = $title ?? data_get($layoutData, 'title', '');
    $metaDescription  = $metaDescription ?? data_get($layoutData, 'metaDescription', '');
    $currentUrl       = url()->current();

    // SEO estructurado (sin llaves Blade dentro del JSON)
    $schema = [
        '@context'    => 'https://schema.org',
        '@type'       => 'Blog',
        'name'        => data_get($layoutData, 'schemaName', ''),
        'url'         => data_get($layoutData, 'schemaUrl', $currentUrl),
        'description' => data_get($layoutData, 'schemaDescription', $metaDescription),
        'publisher'   => [
            '@type' => 'Organization',
            'name'  => data_get($layoutData, 'schemaPublisher', ''),
            'logo'  => [
                '@type' => 'ImageObject',
                'url'   => data_get($layoutData, 'schemaLogo', ''),
            ],
        ],
    ];
@endphp

<!-- Codificación de caracteres -->
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<!-- SEO básico -->
<meta name="description" content="{{ $metaDescription }}" />
<meta name="keywords" content="{{ data_get($layoutData, 'metaKeywords', '') }}" />
<meta name="author" content="{{ data_get($layoutData, 'metaAuthor', '') }}" />
<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />

<!-- Open Graph -->
<meta property="og:type" content="website" />
<meta property="og:title" content="{{ data_get($layoutData, 'ogTitle', $title) }}" />
<meta property="og:description" content="{{ data_get($layoutData, 'ogDescription', $metaDescription) }}" />
<meta property="og:image" content="{{ data_get($layoutData, 'ogImage', '') }}" />
<meta property="og:url" content="{{ data_get($layoutData, 'ogUrl', $currentUrl) }}" />
<meta property="og:site_name" content="{{ data_get($layoutData, 'ogSiteName', '') }}" />

<!-- Twitter Cards -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{{ data_get($layoutData, 'twitterTitle', $title) }}" />
<meta name="twitter:description" content="{{ data_get($layoutData, 'twitterDescription', $metaDescription) }}" />
<meta name="twitter:image" content="{{ data_get($layoutData, 'twitterImage', '') }}" />
<meta name="twitter:site" content="{{ data_get($layoutData, 'twitterSite', '') }}" />
<meta name="twitter:creator" content="{{ data_get($layoutData, 'twitterCreator', '') }}" />

<!-- Favicon -->
<link rel="icon" href="{{ data_get($layoutData, 'favicon', asset('images/favicon.ico')) }}" type="image/x-icon" />
<link rel="apple-touch-icon" href="{{ data_get($layoutData, 'appleTouchIcon', asset('images/apple-touch-icon.png')) }}" />
<link rel="icon" type="image/png" sizes="32x32" href="{{ data_get($layoutData, 'favicon32', asset('images/favicon-32x32.png')) }}" />
<link rel="icon" type="image/png" sizes="16x16" href="{{ data_get($layoutData, 'favicon16', asset('images/favicon-16x16.png')) }}" />
<link rel="mask-icon" href="{{ data_get($layoutData, 'safariMaskIcon', asset('images/safari-pinned-tab.svg')) }}" color="#5bbad5" />

<!-- Canonical -->
<link rel="canonical" href="{{ data_get($layoutData, 'canonical', $currentUrl) }}" />

<!-- Schema.org (SEO estructurado) -->
<script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>

<!-- Estilos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
<link href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ blog_assets('default', 'css', 'main2.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ blog_assets('default', 'css', 'app.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ blog_assets('default', 'css', 'wirecomments.css') }}" type="text/css" />

<!-- Scripts -->
<script src="{{ blog_assets('default', 'js', 'main.js') }}" type="text/javascript"></script>

<!-- Livewire -->
@livewireStyles

<title>{{ $title }}</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.min.css" />
@laravelTelInputStyles

@stack('styles')
