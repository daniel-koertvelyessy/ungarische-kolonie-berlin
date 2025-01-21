<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
            <link rel="icon" href="{{ Vite::asset('./resources/images/favicons/favicon.ico') }}" sizes="48x48" >
            <link rel="icon" href="{{ Vite::asset('./resources/images/kolonia_icon.svg') }}" sizes="any" type="image/svg+xml">
            <link rel="apple-touch-icon" href="{{ Vite::asset('./resources/images/favicons/apple-icon-180x180.png') }}">
            <link rel="manifest" href="{{ Vite::asset('./resources/images/favicons/manifest.json') }}">


        @else
            <script src="https://cdn.tailwindcss.com"></script>
        @endif


    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <div class="bg-zinc-50 text-black/50 dark:bg-black dark:text-white/50">
            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                        <div class="flex lg:justify-center lg:col-start-2">
                            <img src="{{ Vite::asset('./resources/images/header.jpg') }}"
                                 alt=""
                            >
                        </div>
                    </header>

                    <main class="mt-6">
                        <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                            <a
                                href="#"
                                id="docs-card"
                                class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
                            >
                                <div class="relative flex items-center gap-6 lg:items-end">
                                    <div id="docs-card-content" class="flex items-start gap-6 lg:flex-col">


                                        <div class="pt-3 sm:pt-5 lg:pt-0">
                                            <h2 class="text-xl font-semibold text-black dark:text-white">Veranstaltungen</h2>

                                            <p class="mt-4 text-sm/relaxed">
                                                Aktuelle Liste der Veranstaltungen
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a
                                href="#"
                                class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
                            >


                                <div class="pt-3 sm:pt-5">
                                    <h2 class="text-xl font-semibold text-black dark:text-white">Der Verein</h2>

                                    <p class="mt-4 text-sm/relaxed">
                                        Gegründet 1845 ...
                                    </p>
                                </div>
                            </a>

                            <a
                                href="#"
                                class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
                            >

                                <div class="pt-3 sm:pt-5">
                                    <h2 class="text-xl font-semibold text-black dark:text-white">Von Ungarn für Ungarn</h2>

                                    <p class="mt-4 text-sm/relaxed">
                                        Der Verein hilft Ungarn, die in Berlin wohnen oder zu Besuch sind. Unser schwarzes Brett kann von Mitgliedern mit Angeboten und Suchen eingesehen werden.
                                    </p>
                                </div>

                            </a>
                            <a
                                href="#"
                                class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
                            >

                                <div class="pt-3 sm:pt-5">
                                    <h2 class="text-xl font-semibold text-black dark:text-white">Mitglied werden</h2>

                                    <p class="mt-4 text-sm/relaxed">
                                        Werden Teil einer lustigen und unternehmungsreichen Gesellschaft
                                    </p>
                                </div>

                            </a>

                        </div>
                    </main>

                    <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                        <a href="{{ route('impressum') }}" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">Impressum</a>
                        @if (Route::has('login'))

                                @auth
                                    <a
                                        href="{{ url('/dashboard') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Dashboard
                                    </a>
                                @else
                                    <a
                                        href="{{ route('login') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Log in
                                    </a>

                                    {{--                                    @if (Route::has('register'))--}}
                                    {{--                                        <a--}}
                                    {{--                                            href="{{ route('register') }}"--}}
                                    {{--                                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"--}}
                                    {{--                                        >--}}
                                    {{--                                            Register--}}
                                    {{--                                        </a>--}}
                                    {{--                                    @endif--}}
                                @endauth

                        @endif
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>
