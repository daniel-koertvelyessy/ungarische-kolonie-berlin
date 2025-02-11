<div class="space-y-6">

    <header class="flex justify-between">
        <flux:heading size="xl">{{ __('event.page.title') }}</flux:heading>
        @can('create',\App\Models\Event::class)
            <flux:button href="{{ route('backend.events.create') }}"
                         variant="primary"
            >Neu erstellen
            </flux:button>
        @endcan
    </header>

    <flux:table :paginate="$this->events">

        <flux:columns>
            <flux:column sortable
                         :sorted="$sortBy === 'title'"
                         :direction="$sortDirection"
                         wire:click="sort('title')"
            >{{ __('event.index.table.header.title') }}</flux:column>
            <flux:column sortable
                         :sorted="$sortBy === 'image'"
                         :direction="$sortDirection"
                         wire:click="sort('image')"
            >{{ __('event.index.table.header.image') }}</flux:column>
            <flux:column sortable
                         :sorted="$sortBy === 'starts_at'"
                         :direction="$sortDirection"
                         wire:click="sort('starts_at')"
                         class="hidden sm:table-cell"
            >{{ __('event.date')}}</flux:column>
            <flux:column sortable
                         :sorted="$sortBy === 'starts_at'"
                         :direction="$sortDirection"
                         wire:click="sort('starts_at')"
                         class="hidden sm:table-cell"
            >{{ __('event.begins')}}</flux:column>
            <flux:column sortable
                         :sorted="$sortBy === 'ends_at'"
                         :direction="$sortDirection"
                         wire:click="sort('ends_at')"
                         class="hidden md:table-cell"
            >{{ __('event.ends')  }}</flux:column>
            <flux:column sortable
                         :sorted="$sortBy === 'venue'"
                         :direction="$sortDirection"
                         wire:click="sort('venue_id')"
                         class="hidden lg:table-cell"
            >{{ __('event.venue') }}</flux:column>
            <flux:column sortable
                         :sorted="$sortBy === 'status'"
                         :direction="$sortDirection"
                         wire:click="sort('status')"
                         class="hidden lg:table-cell"
            >{{ __('event.status') }}</flux:column>
        </flux:columns>

        <flux:rows>
            @foreach ($this->events as $event)
                <flux:row :key="$event->id">
                    <flux:cell>
                        <a class="underline text-emerald-600"
                           href="{{ route('backend.events.show',$event) }}"
                        >{{ Str::limit($event->title[$locale], 45, preserveWords: true)  }}</a>
                    </flux:cell>
                    <flux:cell>
                        @if($event->image)
                            <flux:icon icon="photo"
                                       class="size-6 ml-3"
                            />
                        @else
                            <flux:icon icon="x-mark"
                                       class="size-4 ml-3"
                            />
                        @endif
                    </flux:cell>


                    <flux:cell class="hidden sm:table-cell">
                        {{ $event->event_date->format('Y-m-d') }}
                    </flux:cell>

                    <flux:cell class="hidden sm:table-cell">
                        {{ optional($event->start_time)->format('H:i') }}
                    </flux:cell>

                    <flux:cell class=" hidden md:table-cell">
                        {{optional($event->end_time)->format('H:i')}}
                    </flux:cell>

                    <flux:cell class=" hidden lg:table-cell"
                               variant="strong"
                    >
                        {{ $event->venue->name }}
                    </flux:cell>
                    <flux:cell>
                        <flux:badge color="{{ \App\Enums\EventStatus::color($event->status) }}">{{ \App\Enums\EventStatus::value($event->status) }}</flux:badge>
                    </flux:cell>
                </flux:row>
            @endforeach
        </flux:rows>
    </flux:table>
</div>

