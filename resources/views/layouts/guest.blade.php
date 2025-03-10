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

    <!-- Styles / Scripts -->
    {{--    @turnstileScripts()--}}
    @fluxAppearance
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
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap"
          rel="stylesheet"
    />

    @if ($hasEvent && isset($event))
        <!-- Canonical URL -->
        <link rel="canonical" href="{{ route('events.show', $event->slug[$locale] ?? $event->slug['de'] ?? '') }}">

        <!-- Meta Tags -->
        <meta name="description" content="{{ $event->description[$locale] ?? __('meta.default_description') }}">
        <meta property="og:title" content="{{ $event->title[$locale] ?? $title }}">
        <meta property="og:description" content="{{ $event->description[$locale] ?? __('meta.default_description') }}">
        <meta property="og:image" content="{{ $event->image_url ?? Vite::asset('resources/images/web-app-manifest-512x512.png') }}">
        <meta property="og:type" content="article">
        <meta property="og:url" content="{{ route('events.show', $event->slug[$locale] ?? $event->slug['de'] ?? '') }}">

        <!-- Twitter Cards -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $event->title[$locale] ?? $title }}">
        <meta name="twitter:description" content="{{ $event->description[$locale] ?? __('meta.default_description') }}">
        <meta name="twitter:image" content="{{ $event->image_url ?? Vite::asset('resources/images/web-app-manifest-512x512.png') }}">

        <!-- Reading Time -->
        @php
            $readingTime = ceil(str_word_count(strip_tags($event->description[$locale] ?? '')) / 200);
        @endphp
        <meta name="article:section" content="Event">
        <meta name="article:published_time" content="{{ $event->created_at?->toIso8601String() }}">
        <meta name="article:modified_time" content="{{ $event->updated_at?->toIso8601String() }}">
        <meta name="article:reading_time" content="{{ $readingTime }} min">

        <!-- Open Graph & Schema.org (for Rich Snippets) -->
        <script type="application/ld+json">
            {!! json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'Event',
                'name' => $event->title[$locale] ?? '',
                'startDate' => $event->start_date?->toIso8601String() ?? '',
                'endDate' => $event->end_date?->toIso8601String() ?? '',
                'location' => [
                    '@type' => 'Place',
                    'name' => $event->venue->name ?? '',
                    'address' => $event->venue->address . ' ' . ($event->venue->postal_code ?? '') . ' ' . ($event->venue->city ?? ''),
                ],
                'image' => $event->image_url ?? Vite::asset('resources/images/web-app-manifest-512x512.png'),
                'description' => $event->description[$locale] ?? '',
                'performer' => [
                    '@type' => 'Organization',
                    'name' => 'Magyar Kolónia Berlin e.V.',
                ],
                'url' => route('events.show', $event->slug[$locale] ?? $event->slug['de'] ?? ''),
            ], JSON_UNESCAPED_UNICODE) !!}
        </script>
    @endif
</head>
<body class="font-sans antialiased">
<div class="bg-zinc-50 text-black/50 dark:bg-zinc-900 dark:text-white/50">
    <div class="relative min-h-screen flex flex-col items-center justify-between selection:bg-[#FF2D20] selection:text-white">
        <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl pt-3 lg:pt-6">
           <x-header />
            <flux:navbar class="lg:hidden justify-between mb-3 border-b border-zinc-200 dark:border-zinc-700">
                <a href="/">
                    <x-application-logo class="size-10 ml-2"/>
                </a>
                <flux:heading>Magyar Kolónia Berlin e.V.</flux:heading>
                <flux:sidebar.toggle class="lg:hidden"
                                     icon="bars-3"
                                     inset="left"
                />
            </flux:navbar>
            {{ $slot }}
        </div>
        <x-guest-footer/>
        @persist('toast')
        <flux:toast position="top right"/>
        @endpersist
@fluxScripts
</body>
</html>
