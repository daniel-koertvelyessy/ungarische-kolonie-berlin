<div>
    <flux:heading size="xl">{{ __('transaction.event.boxoffice.heading') }}</flux:heading>


    <form wire:submit="addBoxOfficePayment">

        <section class="space-y-6 pt-6">

            <flux:separator text="{{ __('transaction.event.boxoffice.paymentsection') }}"/>

            <flux:field>
                <flux:label>Eintritt</flux:label>
                <flux:input.group>
                    <flux:input wire:model="form.amount_gross"
                                x-mask:dynamic="$money($input, ',')"
                    />
                    <flux:input.group.suffix>EUR</flux:input.group.suffix>
                </flux:input.group>
            </flux:field>

            <flux:select variant="listbox"
                         searchable
                         placeholder="{{ __('transaction.account.name') }}"
                         wire:model="form.account_id"
                         label="Kasse wählen"
            >
                @foreach($accountList as $account)
                    <flux:select.option value="{{$account->id}}">{{ $account->name }}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:select variant="listbox"
                         searchable
                         placeholder="{{ __('transaction.account.name') }}"
                         wire:model="form.booking_account_id"
                         label="Konto wählen"
            >
                @foreach($bookingAccountList as $account)
                    <flux:select.option value="{{$account->id}}">{{ $account->number }}
                        - {{ $account->label }}</flux:select.option>
                @endforeach
            </flux:select>


            <flux:separator text="{{ __('transaction.event.boxoffice.visitorsection') }}"/>

           <flux:field>
               <flux:label>Karten für Frauen</flux:label>
               <flux:input.group>
                   <flux:button icon="plus" variant="filled" x-on:click="$wire.femaleTicketCounter = $wire.femaleTicketCounter+1"></flux:button>
                   <flux:button icon="minus" variant="filled" x-on:click="$wire.femaleTicketCounter = $wire.femaleTicketCounter-1"></flux:button>
                   <flux:input wire:model="femaleTicketCounter"/>
               </flux:input.group>
           </flux:field>
            <flux:field>
               <flux:label>Karten für Männer</flux:label>
               <flux:input.group>
                   <flux:button icon="plus" variant="filled" x-on:click="$wire.maleTicketCounter = $wire.maleTicketCounter+1"></flux:button>
                   <flux:button icon="minus" variant="filled" x-on:click="$wire.maleTicketCounter = $wire.maleTicketCounter-1"></flux:button>
                   <flux:input wire:model="maleTicketCounter"/>
               </flux:input.group>
           </flux:field>

            <flux:button type="sumbit"
                         class="w-full"
                         variant="primary"
            >{{__('transaction.event.boxoffice.submit')}}</flux:button>

        </section>


    </form>
</div>
