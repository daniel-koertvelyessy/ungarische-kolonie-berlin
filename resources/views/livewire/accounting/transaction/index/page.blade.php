<div x-data="{showFilter: false}">
    <header class="flex justify-between items-center mb-3 lg:mb-6">
        <flux:heading size="xl">Übersicht der Buchungen</flux:heading>
        <flux:button icon="adjustments-horizontal"
                     size="sm"
                     @click="showFilter = ! showFilter"
        ></flux:button>
    </header>

    <nav class="my-2 hidden gap-3 lg:flex items-center "
         x-cloak
         x-show="showFilter"
    >

        <flux:checkbox.group wire:model.live="filter_status"
                             label="Status"
        >
            @foreach(\App\Enums\TransactionStatus::cases() as $status)
                <flux:checkbox value="{{ $status->value }}"
                               label="{{ $status->value }}"
                />
            @endforeach
        </flux:checkbox.group>

        <flux:checkbox.group wire:model.live="filter_type"
                             label="Typ"
        >
            @foreach(\App\Enums\TransactionType::cases() as $type)
                <flux:checkbox value="{{ $type->value }}"
                               label="{{ $type->value }}"
                />
            @endforeach
        </flux:checkbox.group>

        <flux:fieldset class="space-y-3">
            <flux:input wire:model.live.debounce="search"
                        clearable
                        size="sm"
                        icon="magnifying-glass"
                        placeholder="Suche ..."
                        class="flex-1 mt-4"
            />
            <flux:select variant="listbox"
                         placeholder="nach Status filtern"
                         wire:model.live="filter_date_range"
                         size="sm"
            >
                @foreach(\App\Enums\DateRange::cases() as $range)
                    <flux:option value="{{ $range->value }}">{{ $range->label() }}</flux:option>
                @endforeach
            </flux:select>
        </flux:fieldset>
    </nav>

    <nav class="flex gap-3 lg:hidden"
         x-cloak
         x-show="showFilter"
    >
        <flux:select variant="listbox"
                     multiple
                     placeholder="nach Status filtern"
                     wire:model.live="filter_status"
                     size="sm"
        >
            @foreach(\App\Enums\TransactionStatus::cases() as $status)
                <flux:option value="{{ $status->value }}">{{ $status->value }}</flux:option>
            @endforeach
        </flux:select>

        <flux:select variant="listbox"
                     multiple
                     placeholder="nach Typ filtern"
                     wire:model.live="filter_type"
                     size="sm"

        >
            @foreach(\App\Enums\Transactiontype::cases() as $status)
                <flux:option value="{{ $status->value }}">{{ $status->value }}</flux:option>
            @endforeach
        </flux:select>
        <flux:input wire:model.live.debounce="search"
                    clearable
                    size="sm"
                    icon="magnifying-glass"
                    class="flex-1"
        />
    </nav>

    <flux:table :paginate="$this->transactions">
        <flux:columns>
            <flux:column>Buchung</flux:column>
            <flux:column sortable
                         :sorted="$sortBy === 'date'"
                         :direction="$sortDirection"
                         wire:click="sort('date')"
                         class="hidden md:table-cell"
            >Erfolgt am
            </flux:column>
            <flux:column sortable
                         :sorted="$sortBy === 'created_at'"
                         :direction="$sortDirection"
                         wire:click="sort('created')"
                         class="hidden md:table-cell"
            >Eingereicht
            </flux:column>
            <flux:column sortable
                         :sorted="$sortBy === 'status'"
                         :direction="$sortDirection"
                         wire:click="sort('status')"
                         class="hidden md:table-cell"
            >Status
            </flux:column>
            <flux:column align="right"
                         sortable
                         :sorted="$sortBy === 'amount_gross'"
                         :direction="$sortDirection"
                         wire:click="sort('amount_gross')"
            >Betrag [EUR]
            </flux:column>
            <flux:column sortable
                         :sorted="$sortBy === 'type'"
                         :direction="$sortDirection"
                         wire:click="sort('type')"
                         class="hidden sm:table-cell"

            >Art
            </flux:column>
            <flux:column class="hidden lg:table-cell">Beleg</flux:column>

        </flux:columns>

        <flux:rows>
            @forelse ($this->transactions as $item)
                <flux:row :key="$item->id">
                    <flux:cell variant="strong">
                        {{ $item->label }}
                    </flux:cell>

                    <flux:cell class="hidden md:table-cell">{{ $item->date->diffForHumans() }}</flux:cell>

                    <flux:cell class="hidden md:table-cell">{{ $item->created_at->diffForHumans() }}</flux:cell>

                    <flux:cell class="hidden md:table-cell">
                        <flux:badge size="sm"
                                    :color="\App\Enums\TransactionStatus::color($item->status)"
                                    inset="top bottom"
                        >{{ $item->status }}</flux:badge>
                    </flux:cell>

                    <flux:cell variant="strong"
                               align="end"
                    ><span class="{{ $item->grossColor() }}">{{ $item->grossForHumans() }}</span></flux:cell>
                    <flux:cell class="hidden sm:table-cell">
                        <flux:badge size="sm"
                                    :color="\App\Enums\TransactionType::color($item->type)"
                                    inset="top bottom"
                        >{{ $item->type }}</flux:badge>
                    </flux:cell>
                    <flux:cell class="hidden lg:table-cell">

                        @if($item->receipts->count() > 0)
                            @foreach($item->receipts as $key => $receipt)

                                <flux:tooltip content="{{ $receipt->file_name_original }}" position="top">
                            <flux:button
                                wire:click="download({{$item->receipt}})"
                                icon-trailing="document-arrow-down"
                                size="xs"
                            />
                                </flux:tooltip>
                            @endforeach
                        @else
                            -
                        @endif
                    </flux:cell>
                    @can('update', \App\Models\Accounting\Account::class)
                        <flux:cell>
                            <flux:dropdown>
                                <flux:button variant="ghost"
                                             size="sm"
                                             icon="ellipsis-horizontal"
                                             inset="top bottom"
                                ></flux:button>

                                <flux:menu>
                                    @if($item->status === \App\Enums\TransactionStatus::submitted->value)

                                        <flux:menu.item icon="check"
                                                        wire:click="bookItem({{ $item->id }})"
                                        >Buchen
                                        </flux:menu.item>

                                        <flux:menu.item icon="pencil"
                                                        wire:click="editItem({{ $item->id }})"
                                        >Bearbeiten
                                        </flux:menu.item>
                                    @else
                                        <flux:menu.item icon="trash"
                                                        wire:click="cancelItem({{ $item->id }})"
                                        >Storno
                                        </flux:menu.item>
                                    @endif
                                </flux:menu>
                            </flux:dropdown>
                        </flux:cell>
                    @endcan
                </flux:row>
            @empty
                <flux:row key="0">
                    <flux:cell colspan="6"
                               class=" space-y-2"
                    >
                        <flux:text>Keine Buchungen gefunden</flux:text>

                    </flux:cell>

                </flux:row>
            @endforelse
        </flux:rows>
    </flux:table>
    @can('create', \App\Models\Accounting\Account::class)
    <div class="flex mt-3">
        <flux:spacer/>
        <flux:button variant="primary"
                     href="{{ route('transaction.create') }}"
        >Neue Buchung anlegen
        </flux:button>
    </div>
    @endcan



    <!-- MODALS -->

    <flux:modal name="edit-transaction"
                class=" space-y-6"
                variant="flyout"
                position="right"
    >
        <flux:heading size="lg">Buchung bearbeiten</flux:heading>

        @if($transaction)
            <livewire:accounting.transaction.create.form :transactionId="$transaction->id"/>
        @endif

    </flux:modal>


    <flux:modal name="book-transaction"
                class=" space-y-6"
                variant="flyout"
                position="right"
    >
        @if($transaction)
            <livewire:accounting.transaction.booking.form :transactionId="$transaction->id"/>
        @endif
    </flux:modal>
</div>
