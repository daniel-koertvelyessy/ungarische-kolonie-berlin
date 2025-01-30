<x-guest-layout title="{{ __('event.page.title') }}">
    <h1 class="text-3xl">{{ __('event.page.title') }}</h1>

    <div class="space-y-4 divide-y divide-emerald-600 mt-3">
        @foreach($events as $event)
            <article class="flex justify-between items-center p-2 flex-col lg:flex-row gap-3 lg:gap-9">
                <section class="flex-1 space-y-2">
                    <flux:heading>{{ $event->title[$locale??'de'] }}</flux:heading>
                    <section class="prose-emerald dark:prose-invert">{!! $event->excerpt[$locale??'de'] !!}</section>

                   <nav class="flex gap-3">
                       <flux:button variant="primary" size="sm" href="{{ route('events.show', $event->slug[app()->getLocale()]) }}">{{ __('event.show.label') }}</flux:button>
                       <flux:button variant="filled"
                                    size="sm"
                                    href="/ics/{{ $event->slug[$locale??'de'] }}"
                                    icon-trailing="calendar-days"
                                    target="_blank"

                       />
                   </nav>

                </section>

                <aside class="w-full lg:w-60 space-y-1 flex-row flex justify-between border-t border-zinc-300 lg:border-t-0 pt-2">
                    <section class="space-y-1 grow">
                        <div class="flex justify-between items-center gap-3">
                            <span>{{ __('event.date') }}:</span>
                            <span>{{ $event->event_date->locale($locale)->isoFormat('LL') }}</span>
                        </div>
                        <div class="flex justify-between items-center gap-3 text-sm">
                            <span>{{ __('event.begins') }}:</span>
                            <span>{{ $event->start_time->locale($locale)->isoFormat('LT') }}</span>
                        </div>
                        <div class="flex justify-between items-center gap-3 text-sm">
                            <span>{{ __('event.ends') }}:</span>
                            <span>{{ $event->end_time->locale($locale)->isoFormat('LT') }}</span>
                        </div>
                        <div class="flex justify-between items-center gap-3 text-sm">
                            <span>{{ __('event.venue') }}:</span>
                            <div>{{ $event->venue->name }}</div>
                        </div>

                    </section>

                </aside>


            </article>
        @endforeach

   <nav class="pt-3 ">
       {{ $events->links() }}
   </nav>
    </div>
</x-guest-layout>
