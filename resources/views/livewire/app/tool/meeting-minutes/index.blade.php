<div>

    <flux:heading size="xl">{{ __('minutes.index.page_title') }}</flux:heading>

    @can('create',\App\Models\MeetingMinute::class)
    <section class="my-3 lg:my-6">
        <flux:button variant="primary" wire:click="create">{{ __('minutes.index.create_button') }}</flux:button>
    </section>
    @endcan

    <section class="grid grid-cols-1 gap-3 lg:grid-cols-3 lg:gap-6">
        <div class="col-span-1">
            <flux:table :paginate="$this->minutes">
                <flux:table.columns>
                    <flux:table.column sortable
                                       :sorted="$sortBy === 'date'"
                                       :direction="$sortDirection"
                                       wire:click="sort('date')"
                    >{{ __('minutes.index.table.header.title') }}
                    </flux:table.column>
                    <flux:table.column sortable
                                       :sorted="$sortBy === 'status'"
                                       :direction="$sortDirection"
                                       wire:click="sort('status')"
                    >{{ __('minutes.index.table.header.date') }}
                    </flux:table.column>
                    <flux:table.column></flux:table.column>
                </flux:table.columns>
                <flux:table.rows>        @foreach ($this->minutes as $item)
                        <flux:table.row :key="$item->id">
                            <flux:table.cell class="flex items-center gap-3">
                                {{ $item->title }}
                            </flux:table.cell>
                            <flux:table.cell class="whitespace-nowrap">{{ $item->meeting_date }}</flux:table.cell>
                            <flux:table.cell>
                                <flux:button variant="ghost"
                                             size="sm"
                                             icon="ellipsis-horizontal"
                                             inset="top bottom"
                                ></flux:button>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach    </flux:table.rows>
            </flux:table>
        </div>

        <aside>
            <flux:heading>Details</flux:heading>
        </aside>
    </section>


</div>
