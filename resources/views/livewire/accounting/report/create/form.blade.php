<div>
    <form wire:submit="storeReportData">
        <section class="space-y-6">
            <flux:radio.group wire:model.live="setRange"
                              label="Zeitraum"
                              variant="segmented"
            >
                <flux:radio value="{{ \Carbon\Carbon::today()->subMonths(2)->month }}"
                            label="{{ \Carbon\Carbon::today()->locale(app()->getLocale())->subMonths(2)->monthName }}"
                />
                <flux:radio value="{{ \Carbon\Carbon::today()->subMonth()->month }}"
                            label="{{ \Carbon\Carbon::today()->locale(app()->getLocale())->subMonth()->monthName }}"
                            checked
                />

                <flux:radio value="{{ \Carbon\Carbon::today()->month }}"
                            label="{{ \Carbon\Carbon::today()->locale(app()->getLocale())->monthName }}"
                />
            </flux:radio.group>
            <section class="grid gap-3 grid-cols-2">
                <flux:date-picker wire:model="form.period_start"
                                  label="Start"
                />
                <flux:date-picker wire:model="form.period_end"
                                  label="Ende"
                />

            </section>
            <flux:button wire:click="getTransactions">Hole Buchungen für Zeitraum</flux:button>
            <flux:accordion transition>
                <flux:accordion.item>
                    <flux:accordion.heading>{{ $msg }}</flux:accordion.heading>

                    <flux:accordion.content class="max-h-36 overflow-y-auto">
                        @if($transactions)
                            <ul>
                                @forelse($transactions as $transaction)
                                    <li class="flex justify-between items-center">
                                        <span>{{ $transaction->label }}</span>
                                        <span class="{{ \App\Enums\TransactionType::color($transaction->type) }} pr-2">{{ number_format($transaction->amount_gross/100 * \App\Enums\TransactionType::calc($transaction->type),2,',','.') }}</span>
                                    </li>
                                @empty
                                    <li>-</li>
                                @endforelse
                            </ul>
                        @endif
                    </flux:accordion.content>
                </flux:accordion.item>
            </flux:accordion>
            <section class="grid gap-3 grid-cols-2">
                <flux:input wire:model="form.starting_amount"
                            label="starting_amount"
                />
                <flux:input wire:model="form.end_amount"
                            label="end_amount"
                />
            </section>
            <section class="grid gap-3 grid-cols-2">
                <flux:input wire:model="form.total_income"
                            label="total_income"
                />
                <flux:input wire:model="form.total_expenditure"
                            label="total_expenditure"
                />
            </section>

            <flux:textarea wire:model="form.notes"
                           rows="auto"
                           label="Notizen"
            />

            <flux:button type="submit">Daten speichern</flux:button>
        </section>


    </form>
</div>
