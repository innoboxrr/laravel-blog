<!DOCTYPE html>
<html lang="en">
    <head>
        @include($themeDir . '.layout.includes.head')
        @laravelTelInputStyles
        @stack('styles')
    </head>
    <body class="font-sans bg-bodyBg text-bodyColor">
        @include($themeDir . '.layout.includes.header')
        <main>
            @yield('content')
        </main>
        @include($themeDir . '.layout.includes.footer')
        @livewireScripts
        @stack('scripts')
        @laravelTelInputScripts
    </body>
</html>