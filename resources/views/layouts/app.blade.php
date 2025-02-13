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
    @fluxStyles
</head>
<body class="font-sans antialiased min-h-screen bg-white dark:bg-zinc-800">
<flux:sidebar sticky
              stashable
              class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700"
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

    <flux:separator />

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

        <flux:navlist.item wire:navigate
                           icon="users"
                           href="{{ route('members.index')  }}"
                           :current="request()->is('*members*')"
        >{{ __('nav.members') }}</flux:navlist.item>

        <flux:navlist.item wire:navigate
                           icon="newspaper"
                           href="#"
        >{{ __('nav.blogs') }}</flux:navlist.item>

        <flux:navlist.item wire:navigate
                           icon="calendar-days"
                           href="{{ route('backend.events.index') }}"
                           :current="request()->is('*events*')"
        >{{ __('nav.events') }}</flux:navlist.item>


        <flux:navlist.group heading="{{ __('nav.kasse') }}"
                            expandable
        >
            <flux:navlist.item href="{{ route('accounting.index') }}">Übersicht</flux:navlist.item>
            <flux:navlist.item href="{{ route('transaction.index') }}">Buchungen</flux:navlist.item>
            <flux:navlist.item href="#">Belege</flux:navlist.item>
            <flux:navlist.item href="#">Berichte</flux:navlist.item>
            @can('create', \App\Models\Accounting\Account::class)
                <flux:navlist.item href="{{ route('accounts.index') }}" :current="request()->is('accounts*')">Konten</flux:navlist.item>
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
                            icon="envelope"
            >{{ __('nav.notifications') }}</flux:menu.item>
            <flux:menu.item wire:navigate
                            icon="user"
                            href="{{ route('profile.show') }}"
            >{{ Auth::user()->first_name. ' '. Auth::user()->name }}</flux:menu.item>
            <flux:menu.item wire:navigate
                            icon="key"
                            href="{{ route('api-tokens.index') }}"
            >{{ __('nav.profile.api') }}</flux:menu.item>


            <flux:menu.separator/>

            <form method="POST"
                  action="{{ route('logout') }}"
            >
                @csrf

                <flux:button type="submit"
                             variant="ghost"
                             icon="arrow-right-start-on-rectangle"
                >{{ __('nav.logout') }}</flux:button>
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
            <flux:menu.item icon="envelope">{{ __('nav.notifications') }}</flux:menu.item>
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

                <flux:button type="submit"
                             icon="arrow-right-start-on-rectangle"
                             variant="ghost"
                >{{ __('nav.logout') }}</flux:button>
            </form>


        </flux:menu>
    </flux:dropdown>
</flux:header>

<flux:main>
    {{ $slot }}
</flux:main>
@fluxScripts
<flux:toast position="top right"
            class="pt-5"
/>
</body>
</html>
