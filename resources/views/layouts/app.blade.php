<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{$title??'Magyar Kolónia Berlin e.V.'}}</title>

        <!-- Fonts -->
        <link rel="preconnect"
              href="https://fonts.bunny.net"
        >
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap"
              rel="stylesheet"
        />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="icon"
              href="{{ Vite::asset('resources/images/favicons/favicon.ico') }}"
              sizes="48x48"
        >
        <link rel="icon"
              href="{{ Vite::asset('resources/images/kolonia_icon.svg') }}"
              sizes="any"
              type="image/svg+xml"
        >
        <link rel="apple-touch-icon"
              href="{{ Vite::asset('resources/images/favicons/apple-icon-180x180.png') }}"
        >
        {{--            <link rel="manifest" href="{{ Vite::asset('resources/images/favicons/manifest.json') }}">--}}

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')
        @livewireScripts
    </body>
</html>
