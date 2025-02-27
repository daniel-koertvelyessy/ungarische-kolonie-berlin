<div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form wire:submit="addEventPayment">

        <section class="space-y-3 mb-6">

            <flux:input type="date" wire:model="transactionForm.date" label="Datum" size="sm" />

            <flux:radio.group wire:model="transactionForm.type"
                              label="Buchung"
                              variant="segmented"
            >
                @foreach(\App\Enums\TransactionType::cases() as $key => $type)
                    <flux:radio :key
                                value="{{ $type->value }}"
                    >{{ $type->value }}</flux:radio>
                @endforeach
            </flux:radio.group>

            <flux:field>
                <flux:select wire:model="transactionForm.account_id"
                             size="sm"
                             placeholder="Zahlungskonto z.B. Barkasse, Bankkonto usw"
                             variant="listbox"
                             clearable
                             searchable
                >
                    @foreach($this->accounts as $key => $account)
                        <flux:select.option :key
                                     value="{{ $account->id }}"
                        >{{ $account->name }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flex:flux:error name="form.account_id"/>
            </flux:field>

            <flux:select placeholder="SKR Konto"
                         wire:model="transactionForm.booking_account_id"
                         size="sm"
                         variant="listbox"
                         clearable
                         searchable
            >
                @foreach($this->booking_accounts as $key => $account)
                    <flux:select.option :key
                                 value="{{ $account->id }}"
                    >{{ $account->number }} - {{ $account->label }}</flux:select.option>
                @endforeach
            </flux:select>


            <flux:input label="Text / Zweck"
                        wire:model="transactionForm.label"
            />

            <flux:input wire:model="transactionForm.amount_gross"
                        x-mask:dynamic="$money($input, ',', '.')"
                        label="Eintritt"
                        @change="updateValuesFromGross"
            />

            <flux:switch wire:model.live="setEntryFee" label="Eintritt rabattiert" />


            <flux:field>
                <flux:select wire:model="member_id" variant="listbox" searchable placeholder="Mitgliedsliste">
                    <flux:select.option value="extern">Extern</flux:select.option>
                    @foreach($this->members as $member)
                    <flux:select.option value="{{ $member->id }}" wire:key="{{ $member->id }}">{{ $member->fullName() }}</flux:select.option>
                    @endforeach
                </flux:select>
            </flux:field>
        </section>

        <flux:button variant="primary" wire:click="storePayment">Zahlung erfassen</flux:button>
    </form>
</div>
