<x-guest-layout title="{{ __('event.title') }}">
    <h1 class="text-3xl">{{ __('event.title') }}</h1>

    <div class="space-y-4 divide-y divide-emerald-600 mt-3">
        @foreach($events as $event)
            <article class="flex justify-between items-center p-2 flex-col lg:flex-row gap-3 lg:gap-9">
                <section class="flex-1 space-y-2">
                    <flux:heading>{{ $event->title[$locale??'de'] }}</flux:heading>
                    <flux:text>{{ $event->description[$locale??'de'] }}</flux:text>
                    <flux:button variant="primary" size="sm" href="{{ route('events.show', $event->slug[app()->getLocale()]) }}">{{ __('event.show.label') }}</flux:button>
                </section>

                <aside class="w-full lg:w-60 space-y-1 flex-row flex justify-between border-t border-zinc-300 lg:border-t-0 pt-2">
                    <section class="space-y-1">
                        <flux:text size="sm">{{ __('event.begins') }}: <br>{{ $event->starts_at->locale($locale)->isoFormat('LLLL') }} </flux:text>
                        <flux:text size="sm">{{ __('event.ends') }}: <br>{{ $event->ends_at->locale($locale)->isoFormat('LLLL') }} </flux:text>
                        <flux:text size="sm">{{ __('event.venue') }}: {{ $event->venue->name }} </flux:text>
                    </section>

                    <flux:button variant="primary"
                                 size="xs"
                                 href="/ics/{{ $event->slug[$locale??'de'] }}"
                                 icon-trailing="calendar-days"
                                 target="_blank"

                    />
                </aside>


            </article>
        @endforeach
    </div>
</x-guest-layout>
