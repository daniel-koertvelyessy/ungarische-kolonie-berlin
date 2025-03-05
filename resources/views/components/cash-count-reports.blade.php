<section class="space-y-6 my-3 ">

    @forelse(\App\Models\Accounting\CashCount::query()->whereYear('cash_counts.counted_at','2025')->latest()->get() as $counting)
        <flux:card class="space-y-3">
            <section class="flex items-center justify-between">
                <div class="flex-1">
                    <flux:heading>{{ $counting->label }}</flux:heading>
                    <flux:text>vom: {{ $counting->counted_at->format('Y-m-d') }}</flux:text>
                </div>
                <aside class="font-bold">  {{ $counting->sumString() }}<span class="text-sm ml-2.5">EUR</span></aside>
            </section>
            <flux:accordion transition>
                <flux:accordion.item>
                    <flux:accordion.heading>Übersicht</flux:accordion.heading>

                    <flux:accordion.content>
                        <section class="grid grid-cols-1 lg:grid-cols-2 gap-3 lg:gap-9">
                            <div>
                                <flux:separator text="Scheine"/>
                                <flux:table>
                                    <flux:table.rows>
                                        <flux:table.row>
                                            <flux:table.cell>200</flux:table.cell>
                                            <flux:table.cell align="end">{{ $counting->euro_two_hundred }}</flux:table.cell>
                                        </flux:table.row>
                                        <flux:table.row>
                                            <flux:table.cell>100</flux:table.cell>
                                            <flux:table.cell align="end">{{ $counting->euro_one_hundred }}</flux:table.cell>
                                        </flux:table.row>
                                        <flux:table.row>
                                            <flux:table.cell>50</flux:table.cell>
                                            <flux:table.cell align="end">{{ $counting->euro_fifty }}</flux:table.cell>
                                        </flux:table.row>
                                        <flux:table.row>
                                            <flux:table.cell>20</flux:table.cell>
                                            <flux:table.cell align="end">{{ $counting->euro_twenty }}</flux:table.cell>
                                        </flux:table.row>
                                        <flux:table.row>
                                            <flux:table.cell>10</flux:table.cell>
                                            <flux:table.cell align="end">{{ $counting->euro_ten }}</flux:table.cell>
                                        </flux:table.row>
                                        <flux:table.row>
                                            <flux:table.cell>5</flux:table.cell>
                                            <flux:table.cell align="end">{{ $counting->euro_five }}</flux:table.cell>
                                        </flux:table.row>


                                    </flux:table.rows>
                                </flux:table>
                            </div>
                            <div>
                                <flux:separator text="Münzen"/>
                                <flux:table>
                                    <flux:table.rows>
                                        <flux:table.row>
                                            <flux:table.cell>2 EUR</flux:table.cell>
                                            <flux:table.cell align="end">{{ $counting->euro_two??0 }}</flux:table.cell>
                                        </flux:table.row>
                                        <flux:table.row>
                                            <flux:table.cell>1 EUR</flux:table.cell>
                                            <flux:table.cell align="end">{{ $counting->euro_one??0 }}</flux:table.cell>
                                        </flux:table.row>
                                        <flux:table.row>
                                            <flux:table.cell>50 Cents</flux:table.cell>
                                            <flux:table.cell align="end">{{ $counting->cent_fifty??0 }}</flux:table.cell>
                                        </flux:table.row>
                                        <flux:table.row>
                                            <flux:table.cell>20 Cents</flux:table.cell>
                                            <flux:table.cell align="end">{{ $counting->cent_twenty??0 }}</flux:table.cell>
                                        </flux:table.row>
                                        <flux:table.row>
                                            <flux:table.cell>10 Cents</flux:table.cell>
                                            <flux:table.cell align="end">{{ $counting->cent_ten??0 }}</flux:table.cell>
                                        </flux:table.row>
                                        <flux:table.row>
                                            <flux:table.cell>5 Cents</flux:table.cell>
                                            <flux:table.cell align="end">{{ $counting->cent_five??0 }}</flux:table.cell>
                                        </flux:table.row>
                                        <flux:table.row>
                                            <flux:table.cell>2 Cents</flux:table.cell>
                                            <flux:table.cell align="end">{{ $counting->cent_two??0 }}</flux:table.cell>
                                        </flux:table.row>
                                        <flux:table.row>
                                            <flux:table.cell>1 Cents</flux:table.cell>
                                            <flux:table.cell align="end">{{ $counting->cent_one??0 }}</flux:table.cell>
                                        </flux:table.row>
                                    </flux:table.rows>
                                </flux:table>
                            </div>
                        </section>





                    </flux:accordion.content>
                </flux:accordion.item>
            </flux:accordion>
        </flux:card>
    @empty
        Keine Zählungen erfasst
    @endforelse


</section>

