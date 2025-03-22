@php use App\Models\Accounting\Account; @endphp
<div>
    <header class="py-3 border-b border-zinc-200 mb-6 flex justify-between">
        <flux:heading size="xl">Kassenjahr {{ session('financialYear') }}</flux:heading>

        <livewire:accounting.fiscal-year-switcher.form/>
    </header>

    <section class="grid grid-cols-1 gap-3 lg:grid-cols-2 xl:grid-cols-3 lg:gap-6">

        <flux:card>
            <flux:heading>Buchungen</flux:heading>

            <flux:table :paginate="$this->transactions">
                <flux:table.columns>
                    <flux:table.column>Bezeichnung</flux:table.column>
                    <flux:table.column sortable
                                       :sorted="$sortBy === 'amount'"
                                       :direction="$sortDirection"
                                       wire:click="sort('amount_gross')"
                    >Betrag
                    </flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @foreach ($this->transactions as $items)
                        <flux:table.row :key="$items->id">
                            <flux:table.cell class="text-wrap hyphens-auto">
                                {{ $items->label }}
                            </flux:table.cell>
                            <flux:table.cell>
                                <span class="{{ $items->grossColor() }}">
                                    {{ $items->grossForHumans() }}
                                </span>
                            </flux:table.cell>

                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>

            <section class="my-3 flex justify-between items-center gap-3">
                <flux:button href="{{ route('transaction.index') }}">Übersicht</flux:button>
                @can('create', Account::class)
                    <flux:button variant="primary"
                                 href="{{ route('transaction.create') }}"
                    ><span class="hidden lg:inline">Buchung</span> Einreichen
                    </flux:button>
                @endcan
            </section>
        </flux:card>

        <flux:card>
            <section class="space-y-6 my-3">
                <flux:separator text="Kontenübersicht"/>
                <x-balance-sheet/>
                <flux:separator text="Kassenzählungen"/>
                <x-cash-count-reports/>
            </section>

        </flux:card>
        <flux:card>
            <flux:heading>Berichte</flux:heading>
            <section class="space-y-6 my-3">

            </section>
        </flux:card>

    </section>

</div>
