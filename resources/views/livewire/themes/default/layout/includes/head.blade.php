<!-- Codificación de caracteres -->
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<!-- SEO básico -->
<meta name="description" content="{{ $layoutData['metaDescription'] ?? '' }}" />
<meta name="keywords" content="{{ $layoutData['metaKeywords'] ?? '' }}" />
<meta name="author" content="{{ $layoutData['metaAuthor'] ?? '' }}" />
<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />

<!-- Open Graph -->
<meta property="og:type" content="website" />
<meta property="og:title" content="{{ $layoutData['ogTitle'] ?? ($title ?? '') }}" />
<meta property="og:description" content="{{ $layoutData['ogDescription'] ?? $metaDescription ?? '' }}" />
<meta property="og:image" content="{{ $layoutData['ogImage'] ?? '' }}" />
<meta property="og:url" content="{{ $layoutData['ogUrl'] ?? url()->current() }}" />
<meta property="og:site_name" content="{{ $layoutData['ogSiteName'] ?? '' }}" />

<!-- Twitter Cards -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{{ $layoutData['twitterTitle'] ?? ($title ?? '') }}" />
<meta name="twitter:description" content="{{ $layoutData['twitterDescription'] ?? $metaDescription ?? '' }}" />
<meta name="twitter:image" content="{{ $layoutData['twitterImage'] ?? '' }}" />
<meta name="twitter:site" content="{{ $layoutData['twitterSite'] ?? '' }}" />
<meta name="twitter:creator" content="{{ $layoutData['twitterCreator'] ?? '' }}" />

<!-- Favicon -->
<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
<link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}" />

<!-- Canonical -->
<link rel="canonical" href="{{ $layoutData['canonical'] ?? url()->current() }}" />

<!-- Schema.org (SEO estructurado) -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Blog",
    "name": "{{ $layoutData['schemaName'] ?? '' }}",
    "url": "{{ $layoutData['schemaUrl'] ?? '' }}",
    "description": "{{ $layoutData['schemaDescription'] ?? $metaDescription ?? '' }}",
    "publisher": {
        "@type": "Organization",
        "name": "{{ $layoutData['schemaPublisher'] ?? '' }}",
        "logo": {
            "@type": "ImageObject",
            "url": "{{ $layoutData['schemaLogo'] ?? '' }}"
        }
    }
}
</script>

<!-- Estilos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
<link href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ blog_assets('default', 'css', 'main.css') }}" type="text/css" />

<!-- Scripts -->
<script src="{{ blog_assets('default', 'js', 'main.js') }}" type="text/javascript"></script>

<!-- Livewire -->
@livewireStyles

<title>{{ $layoutData['title'] ?? '' }}</title>
