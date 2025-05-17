<!DOCTYPE html>
<html lang="en">
    <head>
        @include($themeDir . '.layout.includes.head')
    </head>
    <body class="font-sans bg-bodyBg text-bodyColor">
        @include($themeDir . '.layout.includes.header')
        <main>
            @yield('content')
        </main>
        @include($themeDir . '.layout.includes.footer')
        @livewireScripts
    </body>
</html>