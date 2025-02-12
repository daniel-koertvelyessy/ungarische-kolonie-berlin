<x-guest-layout :title="__('event.show.title')">
    <h1 class="text-xl mb-3">{{ __('event.show.title') }}: {{ $event->title[$locale??'de'] }}</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 lg:gap-6">
        <article>
            <flux:text class="my-3 prose prose-emerald dark:prose-invert">{!! $event->description[$locale??'de']  !!}</flux:text>


            @if($event->image)
                <img src="{{ asset('storage/images/'.$event->image) }}"
                     alt=""
                     class="my-3 lg:my-9 rounded-md shadow"
                >
            @endif
        </article>
        <aside>
            <flux:card>
                <dl class="divide-y divide-gray-100">

                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-900 dark:text-emerald-400">{{ __('event.date') }}</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0">{{ $event->event_date->locale($locale)->isoFormat('LLLL') }}</dd>
                    </div>

                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-900 dark:text-emerald-400">{{ __('event.begins') }}</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0">{{ $event->start_time->format('H:i') }}</dd>
                    </div>

                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-900 dark:text-emerald-400">{{ __('event.ends') }}</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0">{{ $event->end_time->format('H:i') }}</dd>
                    </div>

                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-900 dark:text-emerald-400">{{ __('event.venue') }}</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0">
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
                        <dt class="text-sm/6 font-medium text-gray-900 dark:text-emerald-400">{{ __('event.make_ics') }}</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0">
                            <flux:button variant="primary"
                                         size="xs"
                                         href="/ics/{{ $event->slug[$locale??'de'] }}"
                                         icon-trailing="calendar-days"
                                         target="_blank"

                            />
                        </dd>
                    </div>
                    @if($event->payment_link)

                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium text-gray-900 dark:text-emerald-400">{{ __('event.buy_tickets') }}</dt>
                            <dd class="mt-1 text-sm/6 text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0">
                                <flux:button href="{{ $event->payment_link }}" target="_blank" variant="primary" icon-trailing="banknotes">PayPal</flux:button>
                            </dd>
                        </div>


                    @endif
                </dl>


            </flux:card>
        </aside>
    </div>

</x-guest-layout>
