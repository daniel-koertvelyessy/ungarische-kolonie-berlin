<div>
    <flux:heading size="lg"
                  class="mb-3"
    >Neue Buchung erfassen
    </flux:heading>
    <div class="grid grid-cols-1 gap-3 lg:grid-cols-3 lg:gap-6">
        <flux:card class="space-y-6"
                   x-data="checkVat"
        >

<!--
Zahlungskonto wie Barkasse, Bankkonto oder PayPal
-->
            <flux:select wire:model="form.account_id"
                         size="sm"
                         placeholder="Zahlungskonto z.B. Barkasse, Bankkonto usw"
                         variant="listbox"
                         clearable
                         searchable
            >
                @can('create', \App\Models\Accounting\Account::class)
                    <flux:option value="new">Neues Zahlungskonto</flux:option>
                @endcan
                @foreach($this->accounts as $key => $account)
                    <flux:option :key
                                 value="{{ $account->id }}"
                    >{{ $account->name }}</flux:option>
                @endforeach
            </flux:select>
            @can('create', \App\Models\Accounting\Account::class)
                <flux:modal.trigger name="add-account-modal"
                                    x-cloak
                                    x-show="$wire.form.account_id === 'new'"
                >
                    <flux:button size="sm">anlgen</flux:button>
                </flux:modal.trigger>
            @endcan

<!--
Buchungskonto nach SKR 49
-->
            <flux:select placeholder="SKR Konto"
                         wire:model="form.booking_account_id"
                         size="sm"
                         variant="listbox"
                         clearable
                         searchable
            >
                @can('create', \App\Models\Accounting\Account::class)
                <flux:option value="new">Neues SKR 49 Buchungskonto </flux:option>
                @endcan
                @foreach($this->booking_accounts as $key => $account)
                    <flux:option :key
                                 value="{{ $account->id }}"
                    >{{ $account->number }} - {{ $account->label }}</flux:option>
                @endforeach
            </flux:select>

            @can('create', \App\Models\Accounting\Account::class)
                <flux:modal.trigger name="add-booking-account-modal"
                                    x-cloak
                                    x-show="$wire.form.booking_account_id === 'new'"
                >
                    <flux:button size="sm">anlegen</flux:button>
                </flux:modal.trigger>
            @endcan

            <div class="grid grid-cols-2">
                <flux:select label="Buchung"
                             wire:model="form.transaction_type"
                             size="sm"
                >
                    @foreach(\App\Enums\TransactionType::cases() as $key => $type)
                        <flux:option :key
                                     value="{{ $type->name }}"
                        >{{ $type->value }}</flux:option>
                    @endforeach
                </flux:select>

                <flux:input type="number"
                            min="1"
                            wire:model="form.vat"
                            size="sm"
                            label="MWSt"
                />

            </div>

            <flux:input wire:model="form.amount_net"
                        x-mask:dynamic="$money($input, ',', '.')"
                        label="Netto"
                        @change="updateValuesFromNet"
            />


            <flux:input wire:model="form.tax"
                        x-mask:dynamic="$money($input, ',', '.')"
                        placeholder="MWst"
                        variant="filled"
                        @changed="updateValuesFromGross"
            />
            <flux:input wire:model="form.amount_gross"
                        x-mask:dynamic="$money($input, ',', '.')"
                        label="Brutto"
                        @change="updateValuesFromGross"
            />


            <flux:spacer/>
            <flux:button variant="primary"
                         :disabled="$check_form"
            >Buchung erfassen
            </flux:button>

        </flux:card>

        <aside class="lg:col-span-2">
            <div class="p-10 m-10 border border-dashed rounded-xl">
                <flux:input type="file"
                            wire:model="form.receipt"
                            accept=".pdf,.jpg,.jpeg,.tif,.tiff"
                />

                <flux:input type="file"
                            wire:model="form.receipt"
                            accept=".pdf,.jpg,.jpeg,.tif,.tiff"
                            accept="image/*" capture="environment"
                />
            </div>
        </aside>

    </div>

    <flux:modal name="add-account-modal"
                variant="flyout"
                class="space-y-6"
                position="left"
    >
        <div>
            <flux:heading size="lg">Zahlungskonto anlegen</flux:heading>
        </div>

        <form wire:submit="addNewAccount" class="space-y-2">

            <flux:field>
                <flux:label>Name</flux:label>
                <flux:input wire:model="account_name" required/>
                <flux:error for="name"/>
            </flux:field>

            <flux:field>
                <flux:label>Nummer</flux:label>
                <flux:input wire:model="account_number" required/>
                <flux:error for="number"/>
            </flux:field>

            <flux:input label="Instutut"
                        wire:model="account_institute"
            />

            <flux:input label="IBAN"
                        wire:model="account_iban"
            />
            <flux:input label="BIC"
                        wire:model="account_bic"
            />

            <div class="flex">
                <flux:spacer/>

                <flux:button type="submit"
                             variant="primary"
                >Anlegen und übernehmen
                </flux:button>
            </div>
        </form>
    </flux:modal>


    <flux:modal name="add-booking-account-modal"
                variant="flyout"
                class="space-y-6"
                position="left"
    >
        <div>
            <flux:heading size="lg">Buchungskonto anlegen</flux:heading>
        </div>

        <form wire:submit="addNewBookingAccount" class="space-y-2">
            <flux:select placeholder="SKR Konto"
                         wire:model="form.booking_account_id"
                         size="sm"
                         variant="listbox"
            >
                @foreach(\App\Enums\BookingAccountType::cases() as $type)
                    <flux:option value="{{ $type->name }}"
                    >{{ $type->value }}</flux:option>
                @endforeach
            </flux:select>



            <flux:field>

            </flux:field>

            <flux:field>
                <flux:label>Nummer</flux:label>
                <flux:input wire:model="account_number" required/>
                <flux:error for="number"/>
            </flux:field>

            <flux:input label="Instutut"
                        wire:model="account_institute"
            />

            <flux:input label="IBAN"
                        wire:model="account_iban"
            />
            <flux:input label="BIC"
                        wire:model="account_bic"
            />

            <div class="flex">
                <flux:spacer/>

                <flux:button type="submit"
                             variant="primary"
                >Anlegen und übernehmen
                </flux:button>
            </div>
        </form>
    </flux:modal>

</div>
@script
<script>
    Alpine.data('checkVat', () => {
        return {
            updateValuesFromGross() {
                let gross = this.updateCents($wire.form.amount_gross) / 100; // Convert cents to euros
                let vat = this.$wire.form.vat;

                let tax = (gross * vat / 100).toFixed(4); // Correct rounding to 2 decimal places

                this.$wire.form.tax = tax;
                this.$wire.form.amount_net = (gross - tax).toFixed(4); // Ensure correct rounding

                this.$wire.form.amount_net = this.maskInput(this.$wire.form.amount_net);
            },

            updateValuesFromNet() {

                let net = this.updateCents(this.$wire.form.amount_net) / 100; // Convert cents to euros
                let vat = this.$wire.form.vat;
                let tax = (net * vat / 100).toFixed(4); // Correct rounding to 2 decimal places
                console.log(tax)
                this.$wire.form.tax = this.maskInput(tax)
                this.$wire.form.amount_gross = this.maskInput(net + tax * 1)

            },

            updateCents(formattedValue) {
                let value = formattedValue
                    .replace(/[^\d,]/g, '')  // Remove non-numeric characters
                    .replace(',', '.');      // Convert decimal separator

                let floatValue = parseFloat(value);
                return isNaN(floatValue) ? 0 : Math.round(floatValue * 100);
            },

            maskInput(value) {
                return new Intl.NumberFormat('de-DE', {
                    style: 'decimal',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(value);
            }

        }
    })
</script>
@endscript
