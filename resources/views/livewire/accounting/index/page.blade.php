<div>
    <header class="py-3 border-b border-zinc-200 mb-6">
        <flux:heading size="xl">Kassenjahr 2025</flux:heading>
    </header>

    <section class="grid grid-cols-1 gap-3 lg:grid-cols-2 xl:grid-cols-3 lg:gap-6">

        <flux:card>
            <flux:heading>Buchungen</flux:heading>

            <flux:table :paginate="$this->transactions">
                <flux:table.columns>
                    <flux:table.column>Bezeichnung</flux:table.column>
                    <flux:table.column>Summe</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @foreach ($this->transactions as $items)
                        <flux:table.row :key="$items->id">
                            <flux:table.cell>
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

            <section class="my-3 flex">
                <flux:button href="{{ route('transaction.index') }}">Übersicht</flux:button>
                @can('create', \App\Models\Accounting\Account::class)

                    <flux:spacer/>
                    <flux:button variant="primary"
                                 href="{{ route('transaction.create') }}"
                    >Buchung Einreichen
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
