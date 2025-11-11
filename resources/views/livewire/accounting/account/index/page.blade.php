<div>

    <header class="flex flex-col sm:flex-row items-end mb-6 space-y-3">
        <flux:heading size="xl">{{ __('account.index.title') }}</flux:heading>
        <flux:spacer />
        <aside class="flex gap-3">
            <flux:select wire:model="selectedAccount" variant="listbox" searchable placeholder="Konto auswählen ..." class="w-52">

                @foreach($this->accounts as $item)
                    <flux:select.option wire:key="{{ $item->id }}" value="{{ $item->id }}">{{ $item->name }}</flux:select.option>
                @endforeach

            </flux:select>
            <flux:button variant="primary" wire:click="editAccount">{{ __('account.index.btn.fetch_data') }}</flux:button>


        </aside>

    </header>


    <section class="grid grid-cols-1 lg:grid-cols-2 gap-3 lg:gap-6">

        <flux:card>
            <flux:heading>Details</flux:heading>
            @if($account)
                <livewire:accounting.account.create.form :account="$account" wire:key="account-form-{{ $account->id }}" />
            @endif
        </flux:card>

        <flux:card>
            <flux:heading>Bewegungen</flux:heading>
            @if($selectedAccount)
            <flux:table :paginate="$this->transactions">
                <flux:table.columns>
                    <flux:table.column>Bezeichnung</flux:table.column>
                    <flux:table.column align="right">Betrag</flux:table.column>
                    <flux:table.column>Typ</flux:table.column>
                    <flux:table.column>Status</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @foreach ($this->transactions as $item)
                        <flux:table.row :key="$item->id">
                            <flux:table.cell>
                                {{ $item->label }}
                            </flux:table.cell>
                            <flux:table.cell align="end">
                               <span class="{{ $item->grossColor() }}">
                                    {{ $item->grossForHumans()}}
                               </span>
                            </flux:table.cell>
                            <flux:table.cell>
                                {{ $item->type }}
                            </flux:table.cell>
                            <flux:table.cell>
                                {{ $item->status }}
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
            @endif

            <aside class="mt-16 flex gap-3">
                <flux:button wire:show="account_is_set" wire:click="createReport">{{ __('account.index.btn.create_report') }}</flux:button>
                <flux:button wire:show="is_cash_account" wire:click="createCashCountReport">{{ __('account.index.btn.create_vcashcount') }}</flux:button>
            </aside>
        </flux:card>

    </section>

    @if($selectedAccount)
    <flux:modal name="create-monthly-report" class="w-full">
        <flux:heading size="lg" class="mb-3 lg:mb-6">{{ __('reports.account.new.header') }}</flux:heading>
        <livewire:accounting.report.create.form :account-id="$selectedAccount" />
    </flux:modal>
   @endif

    @if($is_cash_account)
        <flux:modal name="create-cash-count" class="w-full">
            <flux:heading size="lg" class="mb-3 lg:mb-6">{{ __('account.cashcount.create.heading') }}</flux:heading>
            <livewire:accounting.report.cash-count.create.form :account-id="$selectedAccount" />
        </flux:modal>
    @endif
</div>
