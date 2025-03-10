<x-guest-layout :title="__('event.show.title')">
    <h1 class="text-xl mb-3">{{ __('event.show.title') }}: {{ $event->title[$locale??'de'] }}</h1>

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
                <h3 class="text-xl font-bold text-zinc-900">Übersicht</h3>

                <dl class="divide-y divide-gray-100">

                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-900 dark:text-emerald-400">{{ __('event.date') }}</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0">{{ $event->event_date->locale($locale)->isoFormat('LL') }}</dd>
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

                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-900 dark:text-emerald-400">{{ __('event.subscribe') }}</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0">
                            <flux:modal.trigger name="subscribe-event">
                                <flux:button variant="primary"
                                             icon-trailing="user-plus"
                                >{{ __('event.subscription.subscribe-button.label') }}</flux:button>
                            </flux:modal.trigger>
                        </dd>
                    </div>
{{--
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm/6 font-medium text-gray-900 dark:text-emerald-400">{{ __('event.tickets.start.label') }}</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0">
                            <flux:modal.trigger name="buy-tickets-to-event">
                                <flux:button variant="primary"
                                             icon-trailing="banknotes"
                                >{{ __('event.tickets.start.btn') }}</flux:button>
                            </flux:modal.trigger>
                        </dd>
                    </div>--}}

                    @if($event->payment_link)

                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-sm/6 font-medium text-gray-900 dark:text-emerald-400">{{ __('event.buy_tickets') }}</dt>
                            <dd class="mt-1 text-sm/6 text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0">
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

            @if($event->timelines)
                <flux:card>
                    <h3 class="text-xl font-bold text-zinc-900">Programmablauf</h3>
                    <table class="w-full text-left whitespace-nowrap my-6">
                        <colgroup>
                            <col class="w-full sm:w-6/12">
                            <col class="lg:w-1/12">
                            <col class="lg:w-1/12">
                            <col>
                        </colgroup>
                        <thead class="border-b border-white/10 text-sm/6">
                        <tr>
                            <th scope="col"
                                class="pr-8 pl-2 font-semibold sm:pl-3 lg:pl-6"
                            >{{ __('event.timeline.title') }}
                            </th>
                            <th scope="col"
                                class="hidden pr-8 pl-0 font-semibold sm:table-cell"
                            >{{ __('event.timeline.start') }}
                            </th>
                            <th scope="col"
                                class="hidden pr-8 pl-0 font-semibold sm:table-cell"
                            >{{ __('event.timeline.end') }}
                            </th>
                            <th scope="col"
                                class="pr-4 pl-0 font-semibold sm:pr-8 sm:text-left lg:pr-20"
                            >{{ __('event.timeline.place') }}
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200">
                        @foreach($event->timelines as $item)
                            <tr>
                                <td class="py-2 pr-8 pl-2 sm:pl-3 lg:pl-6">
                                    <div class="flex flex-col">
                                        @if($item->title_extern)
                                            <span class="wrap-text">{{ $item->title_extern[$locale??'de'] }}</span>
                                        @endif

                                        @if($item->performer)
                                            <span class="text-sm wrap-text hyphens-auto">{{ __('event.timeline.performer') }}:&shy; {{ $item->performer }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="hidden py-4 pr-4 pl-0 sm:table-cell sm:pr-8">
                                    {{ $item->start }}
                                </td>
                                <td class="hidden py-4 pr-4 pl-0 sm:table-cell sm:pr-8">
                                    {{ $item->end }}
                                </td>
                                <td class="pr-4 pl-0 font-semibold sm:pr-8 lg:pr-20">
                                    {{ $item->place }}
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </flux:card>
            @endif
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
