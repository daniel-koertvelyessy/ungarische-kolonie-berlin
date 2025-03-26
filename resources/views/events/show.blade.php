<x-guest-layout :title="$event->title[$locale]">
    <x-slot name="head">
        <!-- Canonical URL -->
        <link rel="canonical"
              href="{{ route('events.show', $event->slug[$locale] ?? $event->slug['de'] ?? '') }}"
        >

        <!-- Meta Tags -->
        <meta name="description"
              content="{{ $event->description[$locale] ?? __('meta.default_description') }}"
        >
        <meta property="og:title"
              content="{{ $event->title[$locale] ?? $title }}"
        >
        <meta property="og:description"
              content="{{ $event->description[$locale] ?? __('meta.default_description') }}"
        >
        <meta property="og:image"
              content="{{ $event->image_url ?? Vite::asset('resources/images/web-app-manifest-512x512.png') }}"
        >
        <meta property="og:type"
              content="article"
        >
        <meta property="og:url"
              content="{{ route('events.show', $event->slug[$locale] ?? $event->slug['de'] ?? '') }}"
        >

        <!-- Twitter Cards -->
        <meta name="twitter:card"
              content="summary_large_image"
        >
        <meta name="twitter:title"
              content="{{ $event->title[$locale] ?? $title }}"
        >
        <meta name="twitter:description"
              content="{{ $event->description[$locale] ?? __('meta.default_description') }}"
        >
        <meta name="twitter:image"
              content="{{ $event->image_url ?? Vite::asset('resources/images/web-app-manifest-512x512.png') }}"
        >

        <!-- Reading Time -->
        @php
            $readingTime = ceil(str_word_count(strip_tags($event->description[$locale] ?? '')) / 200);
        @endphp
        <meta name="article:section"
              content="Event"
        >
        <meta name="article:published_time"
              content="{{ $event->created_at?->toIso8601String() }}"
        >
        <meta name="article:modified_time"
              content="{{ $event->updated_at?->toIso8601String() }}"
        >
        <meta name="article:reading_time"
              content="{{ $readingTime }} min"
        >

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
    </x-slot>

    <flux:subheading>{{ __('event.show.title') }}:</flux:subheading>
    <h1 class="text-xl mb-3"> {{ $event->title[$locale??'de'] }}</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 lg:gap-6">

        <article>
            <flux:text class="my-3 prose prose-emerald dark:prose-invert">{!! $event->description[$locale??'de']  !!}</flux:text>


            @if($event->image)
                <img src="{{ asset('storage/images/'.$event->image) }}"
                     alt=""
                     class="my-3 lg:my-9 rounded-md shadow-sm"
                >
            @endif

        </article>

        <aside class="space-y-6">
            <flux:card>
                <h3 class="text-xl font-bold text-zinc-900 dark:text-emerald-400">{{ __('event.show.details.heading') }}</h3>

                <dl class="divide-y divide-zinc-100">

                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-zinc-900 dark:text-emerald-400">{{ __('event.date') }}</dt>
                        <dd class="mt-1 text-sm/6 text-zinc-700 dark:text-zinc-100 sm:col-span-2 sm:mt-0">{{ $event->event_date->locale($locale)->isoFormat('LL') }}</dd>
                    </div>

                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-zinc-900 dark:text-emerald-400">{{ __('event.begins') }}</dt>
                        <dd class="mt-1 text-sm/6 text-zinc-700 dark:text-zinc-100 sm:col-span-2 sm:mt-0">{{ $event->start_time->format('H:i') }}</dd>
                    </div>

                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-zinc-900 dark:text-emerald-400">{{ __('event.ends') }}</dt>
                        <dd class="mt-1 text-sm/6 text-zinc-700 dark:text-zinc-100 sm:col-span-2 sm:mt-0">{{ $event->end_time->format('H:i') }}</dd>
                    </div>

                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-zinc-900 dark:text-emerald-400">{{ __('event.venue') }}</dt>
                        <dd class="mt-1 text-sm/6 text-zinc-700 dark:text-zinc-100 sm:col-span-2 sm:mt-0">
                            {{ $event->venue->name }}
                            <ul>
                                <li>{{ $event->venue->address }}</li>
                                <li>{{ $event->venue->postal_code }}, {{ $event->venue->city }}</li>
                                <li>
                                    <a href="tel:{{ $event->venue->phone }}"
                                       class="flex items-center gap-3 underline"
                                    >
                                        <flux:icon.phone variant="micro"/> {{ $event->venue->phone }}</a>
                                </li>
                                <li>
                                    <a href="tel:{{ $event->venue->website }}"
                                       class="flex items-center gap-3 underline"
                                       target="_blank"
                                    >
                                        <flux:icon.link variant="micro"/> {{ $event->venue->website }}</a>
                                </li>
                            </ul>

                        </dd>
                    </div>

                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-zinc-900 dark:text-emerald-400">{{ __('event.make_ics') }}</dt>
                        <dd class="mt-1 text-sm/6 text-zinc-700 dark:text-zinc-100 sm:col-span-2 sm:mt-0">
                            <flux:button variant="primary"
                                         size="xs"
                                         href="{{ route('events.ics',$event->slug[$locale??'de'] ) }}"
                                         icon-trailing="calendar-days"
                                         target="_blank"

                            />
                        </dd>
                    </div>

                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-zinc-900 dark:text-emerald-400">{{ __('event.subscribe') }}</dt>
                        <dd class="mt-1 text-sm/6 text-zinc-700 dark:text-zinc-100 sm:col-span-2 sm:mt-0">
                            <flux:modal.trigger name="subscribe-event">
                                <flux:button variant="primary"
                                             icon-trailing="user-plus"
                                >{{ __('event.subscription.subscribe-button.label') }}</flux:button>
                            </flux:modal.trigger>
                        </dd>
                    </div>

                    @if($event->payment_link)

                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium text-zinc-900 dark:text-emerald-400">{{ __('event.buy_tickets') }}</dt>
                            <dd class="mt-1 text-sm/6 text-zinc-700 dark:text-zinc-100 sm:col-span-2 sm:mt-0">
                                <flux:button href="{{ $event->payment_link }}"
                                             target="_blank"
                                             variant="primary"
                                             icon-trailing="banknotes"
                                >PayPal
                                </flux:button>
                            </dd>
                        </div>

                    @endif
                </dl>


            </flux:card>


            <flux:card>
                <h3 class="text-xl font-bold text-zinc-900 dark:text-emerald-400">{{ __('event.show.timeline.heading') }}</h3>
                @if($event->timelines->count()>0)
                    <flux:table>
                        <flux:table.columns>
                            <flux:table.column class="hidden lg:table-cell">{{ __('event.timeline.title') }}</flux:table.column>
                            <flux:table.column class="hidden lg:table-cell">{{ __('event.timeline.start') }}</flux:table.column>
                            <flux:table.column class="hidden lg:table-cell">{{ __('event.timeline.end') }}</flux:table.column>
                            <flux:table.column class="hidden md:table-cell">{{ __('event.timeline.place') }}</flux:table.column>
                        </flux:table.columns>

                        <flux:table.rows>
                            @foreach($event->timelines as $item)
                                <flux:table.row>
                                    <flux:table.cell>

                                        <div class="hidden lg:flex">
                                            @if($item->title_extern)
                                                <span class="text-wrap"> {{ $item->title_extern[$locale??'de'] }}</span>
                                            @endif
                                        </div>

                                        <div class="flex flex-col space-y-3 md:hidden">

                                            @if($item->title_extern)
                                                <div class="flex flex-col">
                                                    {{ __('event.timeline.title') }}:
                                                    <span class="text-wrap hyphens-auto  text-lg">{{ $item->title_extern[$locale??'de'] }}</span>
                                                </div>

                                            @endif

                                            @if($item->performer)
                                                <div class="flex flex-col">
                                                    {{ __('event.timeline.performer') }}:
                                                    <span class="text-wrap hyphens-auto text-lg">{{ $item->performer }}</span>
                                                </div>
                                            @endif

                                            @if($item->place)
                                                <div class="flex flex-col">
                                                    {{ __('event.timeline.place') }}
                                                    <span class="text-wrap hyphens-auto text-lg">{{ $item->place }}</span>
                                                </div>
                                            @endif
                                            <aside class="">
                                                <flux:badge color="green"
                                                            size="sm"
                                                            inset="top bottom"
                                                >{{ $item->start }}</flux:badge>
                                                -
                                                <flux:badge color="green"
                                                            size="sm"
                                                            inset="top bottom"
                                                >{{ $item->end }}</flux:badge>
                                            </aside>
                                        </div>
                                    </flux:table.cell>
                                    <flux:table.cell class="hidden lg:table-cell">
                                        <flux:badge color="green"
                                                    size="sm"
                                                    inset="top bottom"
                                        >{{ $item->start }}</flux:badge>
                                    </flux:table.cell>
                                    <flux:table.cell class="hidden lg:table-cell">
                                        <flux:badge color="green"
                                                    size="sm"
                                                    inset="top bottom"
                                        >{{ $item->end }}</flux:badge>
                                    </flux:table.cell>
                                    <flux:table.cell class="hidden md:table-cell"
                                                     variant="strong"
                                    >{{ $item->place }}</flux:table.cell>
                                </flux:table.row>
                            @endforeach

                        </flux:table.rows>
                    </flux:table>
                @else

                    <flux:callout color="emerald" class="my-9">
                        <flux:callout.heading icon="newspaper">{{ __('event.show.timeline.empty.heading') }}</flux:callout.heading>
                        <flux:callout.text>{{ __('event.show.timeline.empty.message') }}</flux:callout.text>
                    </flux:callout>

                @endif
            </flux:card>

        </aside>
    </div>


    <flux:modal name="subscribe-event"
                class="md:w-96 space-y-6"
                variant="flyout"
                position="right"
    >
        <livewire:event.subscription.create.form :event-id="$event->id"/>
    </flux:modal>


    <flux:modal name="buy-tickets-to-event"
                class="md:w-96 space-y-6"
                variant="flyout"
                position="right"
    >
        <livewire:event.subscription.create.form :event-id="$event->id"/>
    </flux:modal>


</x-guest-layout>
