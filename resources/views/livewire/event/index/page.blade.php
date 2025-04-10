
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
            @foreach(App\Enums\EventStatus::cases() as $type)
                <flux:select.option value="{{ $type->value }}">{{ App\Enums\EventStatus::value($type->value) }}</flux:select.option>
            @endforeach
        </flux:select>

    </nav>

    <flux:table :paginate="$this->events">
        <flux:table.columns>
            <flux:table.column sortable
                               :sorted="$sortBy === 'name'"
                               :direction="$sortDirection"
                               wire:click="sort('name')"
            >{{ __('event.index.table.header.name') }}</flux:table.column>
            <flux:table.column sortable
                               :sorted="$sortBy === 'image'"
                               :direction="$sortDirection"
                               wire:click="sort('image')"
                               class="hidden sm:table-cell"
            >{{ __('event.index.table.header.image') }}</flux:table.column>
            <flux:table.column sortable
                               :sorted="$sortBy === 'subscriptions'"
                               :direction="$sortDirection"
                               wire:click="sort('subscriptions')"
                               class="hidden sm:table-cell"
            >{{ __('event.index.table.header.subscriptions') }}</flux:table.column>
            <flux:table.column sortable
                               :sorted="$sortBy === 'date'"
                               :direction="$sortDirection"
                               wire:click="sort('event_date')"
                               class="hidden sm:table-cell"
            >{{ __('event.date')}}</flux:table.column>
            <flux:table.column sortable
                               :sorted="$sortBy === 'starts_at'"
                               :direction="$sortDirection"
                               wire:click="sort('starts_at')"
                               class="hidden sm:table-cell"
            >{{ __('event.begins')}}</flux:table.column>
            <flux:table.column sortable
                               :sorted="$sortBy === 'ends_at'"
                               :direction="$sortDirection"
                               wire:click="sort('ends_at')"
                               class="hidden md:table-cell"
            >{{ __('event.ends')  }}</flux:table.column>
            <flux:table.column sortable
                               :sorted="$sortBy === 'venue'"
                               :direction="$sortDirection"
                               wire:click="sort('venue_id')"
                               class="hidden lg:table-cell"
            >{{ __('event.venue') }}</flux:table.column>
            <flux:table.column sortable
                               :sorted="$sortBy === 'status'"
                               :direction="$sortDirection"
                               wire:click="sort('status')"
            >{{ __('event.status') }}</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($this->events as $event)
                <flux:table.row :key="$event->id">
                    <flux:table.cell variant="strong">
                        <a class="underline text-emerald-600"
                           href="{{ route('backend.events.show',$event) }}"
                        >{{ \Illuminate\Support\Str::limit($event->name??'öffnen', 45, preserveWords: true)  }}</a>
                    </flux:table.cell>
                    <flux:table.cell class="hidden sm:table-cell">
                        @if($event->image)
                            <flux:icon icon="photo"
                                       class="size-6 ml-3"
                            />
                        @else
                            <flux:icon icon="x-mark"
                                       class="size-4 ml-3"
                            />
                        @endif
                    </flux:table.cell>
                    <flux:table.cell class="hidden sm:table-cell">
                       <flux:badge color="{{ $event->subscriptions->count() > 0 ? 'lime' : 'grey' }}" size="sm"> {{ $event->subscriptions->count() }}</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell class="hidden sm:table-cell">
                        {{ optional($event->event_date)->format('Y-m-d') }}
                    </flux:table.cell>

                    <flux:table.cell class="hidden sm:table-cell">
                        {{ optional($event->start_time)->format('H:i') }}
                    </flux:table.cell>

                    <flux:table.cell class=" hidden md:table-cell">
                        {{optional($event->end_time)->format('H:i')}}
                    </flux:table.cell>

                    <flux:table.cell class=" hidden lg:table-cell"
                                     variant="strong"
                    >
                        {{ optional( $event->venue)->name }}
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:badge size="sm"
                                    color="{{ App\Enums\EventStatus::color($event->status) }}"
                        >{{ App\Enums\EventStatus::value($event->status) }}</flux:badge>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>

