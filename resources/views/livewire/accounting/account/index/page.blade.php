<div>

    <header class="flex flex-col sm:flex-row items-end mb-6 space-y-3">
        <flux:heading size="xl">Kontenübersicht</flux:heading>
        <flux:spacer />
        <aside class="flex gap-3">
            <flux:select wire:model="selectedAccount" variant="listbox" searchable placeholder="Konto auswählen ..." class="w-52">

                @foreach($this->accounts as $item)
                    <flux:option wire:key="{{ $item->id }}" value="{{ $item->id }}">{{ $item->name }}</flux:option>
                @endforeach

            </flux:select>
            <flux:button variant="primary" wire:click="editAccount">Hole Daten</flux:button>
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

                @php

                    $total = $account->starting_amount/100;
                    $sub = 0;
 @endphp
            <flux:table :paginate="$this->transactions">
                <flux:columns>
                    <flux:column>Bezeichnung</flux:column>
                    <flux:column align="right">Betrag</flux:column>
                    <flux:column>Typ</flux:column>
                    <flux:column>Status</flux:column>
                </flux:columns>

                <flux:rows>
                    @foreach ($this->transactions as $item)
                        <flux:row :key="$item->id">
                            <flux:cell>
                                {{ $item->label }}
                            </flux:cell>
                            <flux:cell align="end">
                               <span class="{{ $item->grossColor() }}">
                                    {{ $item->grossForHumans()}}
                               </span>
                                @php
                                    $sub += $item->amount_gross/100 *  \App\Enums\TransactionType::calc($item->type);
                                    $total += $item->amount_gross/100 ;
                                @endphp
                            </flux:cell>
                            <flux:cell>
                                {{ $item->type }}
                            </flux:cell>
                            <flux:cell>
                                {{ $item->status }}
                            </flux:cell>
                        </flux:row>
                    @endforeach
                </flux:rows>
            </flux:table>

               <aside class="flex">
                   <flux:spacer />
                   <div>
                       <flux:subheading>Gesamt {{ number_format($sub, 2,',','.') }}</flux:subheading>
                       <flux:heading>Stand Konto {{ number_format($total, 2,',','.') }}</flux:heading>
                   </div>
               </aside>
            @endif
        </flux:card>

    </section>
</div>
