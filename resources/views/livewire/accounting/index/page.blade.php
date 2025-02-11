<div>
    <header class="py-3 border-b border-zinc-200 mb-6">
        <flux:heading size="xl">Kassenjahr 2025</flux:heading>
    </header>

    <section class="grid grid-cols-1 gap-3 md:grid-cols-2 lg:grid-cols-3 lg:gap-6">

        <flux:card>
            <flux:heading>Buchungen</flux:heading>

            <flux:table :paginate="$this->transactions">
                <flux:columns>
                    <flux:column>Bezeichnung</flux:column>
                    <flux:column>Summe</flux:column>
                </flux:columns>

                <flux:rows>
                    @foreach ($this->transactions as $items)
                        <flux:row :key="$items->id">
                            <flux:cell>
                                {{ $items->label }}
                            </flux:cell>
                            <flux:cell>
                                <span class="{{ $items->grossColor() }}">
                                    {{ $items->grossForHumans() }}
                                </span>
                            </flux:cell>

                        </flux:row>
                    @endforeach
                </flux:rows>
            </flux:table>


            <section class="my-3 flex">
                <flux:button href="{{ route('transaction.index') }}">Übersicht</flux:button>
                @can('create', \App\Models\Accounting\Account::class)

                <flux:spacer />
                <flux:button variant="primary"
                             href="{{ route('transaction.create') }}"
                >Buchung Einreichen
                </flux:button>
                    @endcan
            </section>
        </flux:card>

        <flux:card>
            <flux:heading>Konten</flux:heading>
            <x-balance-sheet/>
        </flux:card>
        <flux:card>
            <flux:heading>Berichte</flux:heading>
            <section class="space-y-6 my-3">
                <flux:button>Kassensturz</flux:button>
            </section>
        </flux:card>

    </section>

</div>
