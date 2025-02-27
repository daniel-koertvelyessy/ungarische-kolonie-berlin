<div class="space-y-6">


    <flux:heading size="xl">{{ __('event.page.title') }}</flux:heading>


    <nav class="flex gap-3 items-center">
        @can('create',\App\Models\Event\Event::class)
            <flux:button href="{{ route('backend.events.create') }}"
                         variant="primary"
                         icon-trailing="plus"
                         size="sm"
            ><span class="hidden lg:inline">{{ __('event.index.btn.start_new') }}</span>
            </flux:button>
            <flux:separator vertical/>
        @endcan


        <flux:input size="sm"
                    wire:model.live.debounce="search"
                    clearable
                    icon="magnifying-glass"
                    placeholder="Suche ..."
        />
        <flux:separator vertical/>
        <flux:select variant="listbox"
                     multiple
                     placeholder="Filter.."
                     size="sm"
                     wire:model.live="filteredBy"
                     selected-suffix="{{ __('gewählt') }}"
        >
            @foreach(\App\Enums\EventStatus::cases() as $type)
                <flux:option value="{{ $type->value }}">{{ \App\Enums\EventStatus::value($type->value) }}</flux:option>
            @endforeach
        </flux:select>

    </nav>

    <flux:table :paginate="$this->events">
        <flux:columns>
            <flux:column sortable
                         :sorted="$sortBy === 'name'"
                         :direction="$sortDirection"
                         wire:click="sort('name')"
            >{{ __('event.index.table.header.name') }}</flux:column>
            <flux:column sortable
                         :sorted="$sortBy === 'image'"
                         :direction="$sortDirection"
                         wire:click="sort('image')"
                         class="hidden sm:table-cell"
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
            >{{ __('event.status') }}</flux:column>
        </flux:columns>

        <flux:rows>
            @foreach ($this->events as $event)
                <flux:row :key="$event->id">
                    <flux:cell variant="strong">
                        <a class="underline text-emerald-600"
                           href="{{ route('backend.events.show',$event) }}"
                        >{{ Str::limit($event->name??'öffnen', 45, preserveWords: true)  }}</a>
                    </flux:cell>
                    <flux:cell class="hidden sm:table-cell" >
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
                        {{ optional($event->event_date)->format('Y-m-d') }}
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
                        {{ optional( $event->venue)->name }}
                    </flux:cell>
                    <flux:cell>
                        <flux:badge size="sm" color="{{ \App\Enums\EventStatus::color($event->status) }}">{{ \App\Enums\EventStatus::value($event->status) }}</flux:badge>
                    </flux:cell>
                </flux:row>
            @endforeach
        </flux:rows>
    </flux:table>
</div>

