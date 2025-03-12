<x-guest-layout title="{{ __('post.index.page.title') }}">

    <x-slot name="head">
        @php
            $readingTime = ceil(str_word_count(strip_tags($post->body[$locale] ?? '')) / 200);
        @endphp
        <!-- Open Graph Meta Tags (Facebook, LinkedIn) -->
        <meta property="og:type" content="article">
        <meta property="og:title" content="{{ Str::limit($post->title[$locale], 70,'..',true) }}">
        <meta property="og:description" content="{{ Str::limit(strip_tags($post->body[$locale]), 160,'..',true) }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image" content="{{ $post->image_url ?? Vite::asset('resources/images/web-app-manifest-512x512.png') }}">
        <meta property="og:site_name" content="Magyar Kolónia Berlin e.V.">
        <meta property="og:locale" content="{{ app()->getLocale() }}">

        <!-- Twitter Card -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ Str::limit($post->title[$locale], 70,'..',true) }}">
        <meta name="twitter:description" content="{{ Str::limit(strip_tags($post->body[$locale]), 160,'..',true) }}">
        <meta name="twitter:image" content="{{ $post->image_url ?? Vite::asset('resources/images/web-app-manifest-512x512.png') }}">

        <!-- article meta tags -->
        <meta name="article:section"
              content="article"
        >
        <meta name="article:published_time"
              content="{{ $post->created_at?->toIso8601String() }}"
        >
        <meta name="article:modified_time"
              content="{{ $post->updated_at?->toIso8601String() }}"
        >
        <meta name="article:reading_time"
              content="{{ $readingTime }} min"
        >

        <!-- Schema.org Structured Data (JSON-LD) -->
        <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "Article",
                "headline": "{{ Str::limit($post->title[$locale], 70,'..',true) }}",
            "description": "{{ Str::limit(strip_tags($post->body[$locale]), 160,'..',true) }}",
            "image": "{{ $post->image_url ?? Vite::asset('resources/images/web-app-manifest-512x512.png') }}",
            "author": {
                "@type": "Organization",
                "name": "Magyar Kolónia Berlin e.V."
            },
            "publisher": {
                "@type": "Organization",
                "name": "Magyar Kolónia Berlin e.V.",
                "logo": {
                    "@type": "ImageObject",
                    "url": "{{ Vite::asset('resources/images/web-app-manifest-512x512.png') }}"
                }
            },
            "datePublished": "{{ $post->created_at->toIso8601String() }}",
            "dateModified": "{{ $post->updated_at->toIso8601String() }}",
            "mainEntityOfPage": {
                "@type": "WebPage",
                "@id": "{{ url()->current() }}"
            }
        }
        </script>
    </x-slot>

    <flux:heading size="xl"
                  class="py-10"
    ><h1>{{ $post->title[$locale]  }}</h1></flux:heading>

    <section class="{{ $images->count()>0 ? ' grid grid-cols-1 lg:grid-cols-3 gap-6 ' :'' }}">
        <div class="prose dark:prose-invert max-w-none w-full {{ $images->count()>0 ? ' border-r col-span-2  ' :'' }}">
            {!! $post->body[$locale] !!}
        </div>
        <aside class="px-1 space-y-6">
            @if($images->count() > 0)
                <flux:subheading size="xl">Bildergalerie</flux:subheading>
                @foreach($images as $image)
                    <figure>
                        <img src="/{{ $image->filename }}"
                             alt="{{ $image->caption[$locale] }}"
                        >
                        <flux:text size="sm">&copy; {{ $image->author }}</flux:text>
                        <figcaption>{{ $image->caption[$locale] }}</figcaption>
                    </figure>
                @endforeach
            @endif
        </aside>
    </section>

</x-guest-layout>
