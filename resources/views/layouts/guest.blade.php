<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      class="scroll-smooth"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1"
    >

    <title>{{$title??'Magyar Kolónia Berlin e.V.'}}</title>

    <!-- Fonts -->
    <link rel="preconnect"
          href="https://fonts.bunny.net"
    >
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap"
          rel="stylesheet"
    />

    <!-- Styles / Scripts -->
    @turnstileScripts()
    @fluxStyles
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


</head>
<body class="font-sans antialiased">
<div class="bg-zinc-50 text-black/50 dark:bg-black dark:text-white/50">
    <div class="relative min-h-screen flex flex-col items-center justify-between selection:bg-[#FF2D20] selection:text-white">
        <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl pt-3 lg:pt-6">
            <header class="flex justify-between items-center mb-6">
                <div>
                    <a href="/">
                        <x-application-logo class="size-52"/>
                    </a>
                </div>

                <img src="{{ Vite::asset('resources/images/magyar_cim.svg') }}"
                     class="h-48"
                     alt=""
                >
            </header>
            <flux:navbar class="lg:hidden justify-end border-t border-zinc-200 dark:border-zinc-700" >
                <flux:sidebar.toggle class="lg:hidden" icon="bars-3" inset="left" />
            </flux:navbar>
            {{ $slot }}
        </div>
        <footer class="py-16 text-center text-sm text-black dark:text-white/70">

            <flux:sidebar stashable sticky class="lg:hidden bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
                <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />
                <flux:navlist variant="outline">
                    <flux:navlist.item wire:navigate href="/" >{{__('app.home')}}</flux:navlist.item>
                    <flux:navlist.item wire:navigate href="{{ route('events') }}" >{{__('app.events')}}</flux:navlist.item>
                    <flux:navlist.item wire:navigate href="{{ route('events') }}" >{{__('app.blog')}}</flux:navlist.item>
                    <flux:navlist.item wire:navigate href="{{ route('about-us') }}" >{{__('app.about-us')}}</flux:navlist.item>
                    <flux:navlist.item wire:navigate href="{{ route('become-a-member') }}" >{{__('app.become-member')}}</flux:navlist.item>
                    <flux:separator />
                    <flux:navlist.item wire:navigate href="{{ route('impressum') }}" >{{__('app.imprint')}}</flux:navlist.item>

                    @if (Route::has('login'))

                        @auth
                            <flux:navlist.item wire:navigate
                                              href="{{ url('/dashboard') }}"
                            >{{__('app.dashboard')}}</flux:navlist.item>
                        @else
                            <flux:navlist.item wire:navigate
                                              href="{{ route('login') }}"
                            >{{__('app.gotologin')}}</flux:navlist.item>


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

                    <flux:navlist.group heading="{{__('app.locale')}}" expandable :expanded="false">
                        @foreach (\App\Enums\Locale::toArray() as $locale)
                        <flux:navlist.item href="{{url('/lang/'.$locale)}}">{{ strtoupper($locale) }}</flux:navlist.item>
                        @endforeach
                    </flux:navlist.group>



                </flux:navlist>
            </flux:sidebar>

            <flux:navbar class="hidden lg:flex" >

                <flux:navbar.item wire:navigate
                                  href="/"
                >{{__('app.home')}}</flux:navbar.item>

                <flux:navbar.item wire:navigate :current="request()->routeIs('events*')"
                                  href="{{ route('events') }}"
                >{{__('app.events')}}</flux:navbar.item>

                <flux:navbar.item wire:navigate :current="request()->routeIs('events*')"
                                  href="{{ route('events') }}"
                >{{__('app.blog')}}</flux:navbar.item>

                <flux:navbar.item wire:navigate
                                  href="{{ route('about-us') }}"
                >{{__('app.about-us')}}</flux:navbar.item>

                <flux:navbar.item wire:navigate
                                  href="{{ route('become-a-member') }}"
                >{{__('app.become-member')}}</flux:navbar.item>

                <flux:navbar.item wire:navigate
                                  href="{{ route('impressum') }}"
                >{{__('app.imprint')}}</flux:navbar.item>

                <flux:dropdown>
                    <flux:navbar.item icon-trailing="chevron-down">{{__('app.locale')}}</flux:navbar.item>

                    <flux:navmenu>
                        @foreach (\App\Enums\Locale::toArray() as $locale)
                            <flux:navmenu.item wire:navigate
                                               href="{{url('/lang/'.$locale)}}"
                            >{{ strtoupper($locale) }}</flux:navmenu.item>
                        @endforeach

                    </flux:navmenu>


                </flux:dropdown>
                @if (Route::has('login'))

                    @auth
                        <flux:navbar.item wire:navigate
                                          href="{{ url('/dashboard') }}"
                        >{{__('app.dashboard')}}</flux:navbar.item>
                    @else
                        <flux:navbar.item wire:navigate
                                          href="{{ route('login') }}"
                        >{{__('app.gotologin')}}</flux:navbar.item>


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
            </flux:navbar>
        </footer>



@fluxScripts
</body>
</html>
