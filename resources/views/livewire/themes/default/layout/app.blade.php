<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mi Paquete')</title>
    @livewireStyles
</head>
<body>
    <header class="bg-gray-800 text-white py-4">
        <div class="container mx-auto">
            <h1>@yield('header', 'Encabezado desde el Paquete')</h1>
        </div>
    </header>
    <main class="container mx-auto mt-4">
        @yield('content')
    </main>
    @livewireScripts
</body>
</html>
