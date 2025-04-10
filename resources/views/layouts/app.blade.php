<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1"
    >
    <meta name="csrf-token"
          content="{{ csrf_token() }}"
    >
@if(isset($title))
    <title>{{$title . ' @ Magyar Kolónia Berlin e.V.'}}</title>
    @else
    <title>Portal @ Magyar Kolónia Berlin e.V.</title>
@endif
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
          href="{{ Vite::asset('resources/images/favicon.ico') }}"
          sizes="48x48"
    >
    <link rel="icon"
          href="{{ Vite::asset('resources/images/magyar-kolonia-logo.svg') }}"
          sizes="any"
          type="image/svg+xml"
    >
    <link rel="apple-touch-icon"
          href="{{ Vite::asset('resources/images/web-app-manifest-512x512.png') }}"
    >
    <link rel="apple-touch-icon"
          sizes="180x180"
          href="{{ Vite::asset('resources/images/apple-touch-icon.png') }}"
    />
    <meta name="apple-mobile-web-app-title"
          content="Kolonia"
    />
    <link rel="icon"
          type="image/png"
          href="{{ Vite::asset('resources/images/favicon-96x96.png') }}"
          sizes="96x96"
    />
    <!-- Fonts -->
    <link rel="preconnect"
          href="https://fonts.bunny.net"
    >
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
          rel="stylesheet"
    />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @fluxAppearance
</head>
<body class="font-sans antialiased min-h-screen bg-white dark:bg-zinc-800">
<flux:sidebar sticky
              stashable
              class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700 w-60"
>
    <div class="flex justify-between">
        <flux:brand href="/"
                    logo="{{ Vite::asset('resources/images/magyar-kolonia-logo.svg') }}"
                    name="Kolónia Portal"
                    class="px-2"
        />

        <flux:sidebar.toggle class="lg:hidden ml-3"
                             icon="x-mark"
        />
    </div>

    <flux:separator/>

    {{--
        <flux:input as="button"
                    variant="filled"
                    placeholder="Search..."
                    icon="magnifying-glass"
        />
    --}}

    <flux:navlist variant="outline">

        <flux:navlist.item wire:navigate
                           icon="home"
                           href="{{ route('dashboard') }}"
                           :current="request()->is('dashboard')"
        >{{ __('nav.dashboard') }}</flux:navlist.item>

        @can('create', \App\Models\Membership\Member::class)
            <flux:navlist.item wire:navigate
                               icon="cog-6-tooth"
                               href="{{ route('tools.index')  }}"
                               :current="request()->is('*tools*')"
            >{{ __('nav.tools') }}</flux:navlist.item>

        @endcan

        <flux:navlist.group heading="{{ __('nav.members') }}"
                            expandable
        >
            <flux:navlist.item wire:navigate
                               href="{{ route('backend.members.index')  }}"
            >{{ __('nav.members.overview') }}</flux:navlist.item>
            <flux:navlist.item wire:navigate
                               href="{{ route('backend.members.roles')  }}"
            >{{ __('nav.members.roles') }}</flux:navlist.item>

        </flux:navlist.group>


        <flux:navlist.item wire:navigate
                           icon="newspaper"
                           href="{{ route('backend.posts.index')  }}"
                           :current="request()->is('*posts*')"
        >{{ __('nav.blogs') }}</flux:navlist.item>

        <flux:navlist.item wire:navigate
                           icon="calendar-days"
                           href="{{ route('backend.events.index') }}"
                           :current="request()->is('*events*')"
        >{{ __('nav.events') }}</flux:navlist.item>


        <flux:navlist.group heading="{{ __('nav.kasse') }}"
                            expandable
        >
            <flux:navlist.item wire:navigate
                               href="{{ route('accounting.index') }}"
            >Übersicht
            </flux:navlist.item>
            <flux:navlist.item wire:navigate
                               href="{{ route('transaction.index') }}"
            >Buchungen
            </flux:navlist.item>
            <flux:navlist.item wire:navigate
                               href="{{ route('receipts.index') }}"
            >Belege
            </flux:navlist.item>
            <flux:navlist.item wire:navigate
                               href="{{ route('accounts.report.index') }}"
            >Berichte
            </flux:navlist.item>
            @can('create', Account::class)
                <flux:navlist.item wire:navigate
                                   href="{{ route('accounts.index') }}"
                                   :current="request()->is('accounts*')"
                >Konten
                </flux:navlist.item>
            @endcan
        </flux:navlist.group>

    </flux:navlist>

    <flux:spacer/>


    <flux:dropdown position="top"
                   align="start"
                   class="max-lg:hidden"
    >
        <flux:profile avatar="{{ Auth::user()->profile_photo_url }}"
                      name="{{ Auth::user()->username }}"
        />

        <flux:menu>
            <flux:menu.item wire:navigate
                            icon="user"
                            href="{{ route('profile.show') }}"
            >{{ Auth::user()->first_name. ' '. Auth::user()->name }}</flux:menu.item>
            <flux:menu.item wire:navigate
                            icon="key"
                            href="{{ route('api-tokens.index') }}"
            >{{ __('nav.profile.api') }}</flux:menu.item>
            <livewire:app.global.notifications-menu/>
            {{--           <flux:menu.separator/>
                       <livewire:app.global.dark-mode-toggle />--}}
            <flux:menu.separator/>
            <livewire:app.global.language-switcher/>
            @if(Auth::user()->is_admin)
                <flux:menu.item href="/log-viewer" target="_blank"
                >Logs</flux:menu.item>
            @endif
            <flux:menu.separator/>
            <form method="POST"
                  action="{{ route('logout') }}"
            >
                @csrf

                <flux:menu.item type="submit"
                                icon="arrow-right-start-on-rectangle"
                >{{ __('nav.logout') }}</flux:menu.item>
            </form>
        </flux:menu>
    </flux:dropdown>
</flux:sidebar>

<flux:header class="lg:hidden">
    <flux:sidebar.toggle class="lg:hidden"
                         icon="bars-2"
                         inset="left"
    />

    <flux:spacer/>

    <flux:dropdown position="top"
                   alignt="start"
    >
        <flux:profile avatar="{{ Auth::user()->profile_photo_url }}"
                      name="{{ Auth::user()->username }}"
        />

        <flux:menu>
            <livewire:app.global.notifications-menu/>
            <livewire:app.global.language-switcher/>
            <flux:menu.item icon="user"
                            href="{{ route('profile.show') }}"
            >{{ Auth::user()->first_name. ' '. Auth::user()->name }}</flux:menu.item>
            <flux:menu.item icon="key"
                            href="{{ route('api-tokens.index') }}"
            >{{ __('nav.profile.api') }}</flux:menu.item>


            <flux:menu.separator/>

            <form method="POST"
                  action="{{ route('logout') }}"
            >
                @csrf

                <flux:menu.item type="submit"
                                icon="arrow-right-start-on-rectangle"
                >{{ __('nav.logout') }}</flux:menu.item>
            </form>


        </flux:menu>
    </flux:dropdown>
</flux:header>

<flux:main>
    {{ $slot }}
</flux:main>
@fluxScripts
@persist('toast')
<flux:toast position="top right"/>
@endpersist
</body>
</html>
