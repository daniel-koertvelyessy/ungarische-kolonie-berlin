<div>
    <aside>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </aside>
    <input type="hidden"
            wire:model="form.id"
    >
    <div class="grid grid-cols-1 gap-3 lg:grid-cols-2 lg:gap-6 xl:grid-cols-3">

        <flux:card x-data="checkVat">
            <form wire:submit="submitTransaction">
                <section class="space-y-3">

                    <flux:radio.group wire:model="form.type"
                                      label="Buchung"
                                      variant="segmented"
                    >
                        @foreach(\App\Enums\TransactionType::cases() as $key => $type)
                            <flux:radio :key
                                        value="{{ $type->value }}"
                            >{{ $type->value }}</flux:radio>
                        @endforeach
                    </flux:radio.group>

                    @can('book-item', \App\Models\Accounting\Account::class)
                        <flux:radio.group wire:model="form.status"
                                          label="Status"
                                          variant="segmented"
                        >
                            @foreach(\App\Enums\TransactionStatus::cases() as $key => $status)
                                <flux:radio :key
                                            value="{{ $status->value }}"
                                >{{ $status->value }}</flux:radio>
                            @endforeach
                        </flux:radio.group>
                    @endcan

                    <flux:input label="vom"
                                wire:model="form.date"
                                type="date"
                    />

                    <!--
                    Zahlungskonto wie Barkasse, Bankkonto oder PayPal
                    -->
                    <flux:field>
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
                        <flex:flux:error name="form.account_id"/>
                    </flux:field>
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
                            <flux:option value="new">Neues SKR 49 Buchungskonto</flux:option>
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

                    <flux:input label="Text / Zweck"
                                wire:model="form.label"
                    />



                    <flux:input wire:model="form.amount_gross"
                                x-mask:dynamic="$money($input, ',', '.')"
                                label="Brutto"
                                @change="updateValuesFromGross"
                    />


                    <flux:input type="number"
                                min="0"
                                wire:model="form.vat"
                                size="sm"
                                label="MWSt"
                    />
                    <flux:input wire:model="form.tax"
                                x-mask:dynamic="$money($input, ',', '.')"
                                placeholder="MWst"
                                variant="filled"
                                @changed="updateValuesFromGross"
                    />


                    <flux:input wire:model="form.amount_net"
                                x-mask:dynamic="$money($input, ',', '.')"
                                label="Netto"
                                @change="updateValuesFromNet"
                    />

                    <div class="flex">
                        <flux:spacer/>
                        <flux:button type="submit"
                                     variant="primary"
                        >Buchung speichern
                        </flux:button>
                    </div>
                </section>
            </form>
        </flux:card>

        <flux:card class="space-y-2 xl:col-span-2">
            <form wire:submit="submitReceipt">
                <flux:heading>Beleg hochladen</flux:heading>
                <section class="grid grid-cols-1 lg:grid-cols-3 gap-3">
                    <flux:input label="Bezeichnung"
                                wire:model="receiptForm.label"
                    />
                    <flux:input label="Belegnummer"
                                wire:model.live.blur="receiptForm.number"
                    />
                    <flux:input label="Belegdatum"
                                type="date"
                                wire:model="receiptForm.date"
                    />
                </section>

                <flux:input label="Beschreibung"
                            wire:model="receiptForm.description"
                />

                <flux:card class="my-4">
                    @if($form->receipt_id)
                        <img src="{{ $previewImagePath }}"
                             alt=""
                             class="size-64"
                        >
                        {{ $previewImagePath }}
                        <flux:button variant="danger" size="sm" icon-trailing="trash" wire:click="deleteFile">Beleg löschen</flux:button>
                        @else
                    <flux:input type="file"
                                wire:model="receiptForm.file_name"
                                accept=".pdf,.jpg,.jpeg,.tif,.tiff"
                                class="hidden sm:flex"
                    />

                    <flux:input type="file"
                                wire:model="receiptForm.file_name"
                                accept=".pdf,.jpg,.jpeg,.tif,.tiff"
                                accept="image/*"
                                capture="environment"
                                class="sm:hidden"
                    />
                    @endif
                    <flux:error name="receiptForm.file_name"/>
                </flux:card>


                <div class="flex">
                    <flux:spacer/>
                    <flux:button type="submit"
                                 variant="primary"
                    >Beleg speichern
                    </flux:button>
                </div>
            </form>
        </flux:card>

    </div>


    <flux:modal name="add-account-modal"
                variant="flyout"
                class="space-y-6"
                position="left"
    >
        <div>
            <flux:heading size="lg">Zahlungskonto anlegen</flux:heading>
        </div>

        <form wire:submit="addAccount"
              class="space-y-2"
        >

            <flux:field>
                <flux:select placeholder="Kontotyp"
                             wire:model="account.type"
                             size="sm"
                             variant="listbox"
                >
                    @foreach(\App\Enums\AccountType::cases() as $type)
                        <flux:option value="{{ $type->value }}"
                        >{{ $type->value }}</flux:option>
                    @endforeach
                </flux:select>
                <flux:error name="account.type"/>
            </flux:field>

            <flux:field>
                <flux:label>Name</flux:label>
                <flux:input wire:model="account.name"
                            required
                />
                <flux:error for="account.name"/>
            </flux:field>

            <flux:field>
                <flux:label>Nummer</flux:label>
                <flux:input wire:model="account.number"
                            required
                />
                <flux:error for="account.number"/>
            </flux:field>

            <flux:input wire:model="account.starting_amount"
                        x-mask:dynamic="$money($input, ',', '.')"
                        label="Startguthaben"
            />

            <flux:input label="Instutut"
                        wire:model="account.institute"
            />

            <flux:input label="IBAN"
                        wire:model="account.iban"
            />
            <flux:input label="BIC"
                        wire:model="account.bic"
            />

            <div class="flex">
                <flux:spacer/>
                <flux:button wire:click="createAccount">Speichern und weiter anlegen</flux:button>
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

        <form wire:submit="addBookingAccount"
              class="space-y-2"
        >
            <flux:field>
                <flux:label>Kontoart</flux:label>
                <flux:select placeholder="SKR Konto"
                             wire:model="booking.type"
                             variant="listbox"
                             clearable=""
                >
                    @foreach(\App\Enums\BookingAccountType::cases() as $type)
                        <flux:option value="{{ $type->value }}"
                        >{{ $type->value }}</flux:option>
                    @endforeach
                </flux:select>
                <flux:error for="booking.type"/>
            </flux:field>


            <flux:field>
                <flux:label>Bezeichnung</flux:label>
                <flux:input wire:model="booking.label"
                            required
                />
                <flux:error for="booking.label"/>
            </flux:field>


            <flux:field>
                <flux:input label="SKR-49 Nummer"
                            wire:model="booking.number"
                />
                <flux:error name="booking.number"/>
            </flux:field>

            <div class="flex">
                <flux:spacer/>
                <flux:button wire:click="createBookingAccount">Speichern und weiter anlegen</flux:button>
                <flux:button type="submit"
                             variant="primary"
                >Anlegen und übernehmen
                </flux:button>
            </div>
        </form>
    </flux:modal>

    <flux:modal name="missing-transaction-modal"
                class="md:w-96 space-y-6"
    >
        <div>
            <flux:heading size="lg">Keine Buchungung</flux:heading>
            <flux:subheading>Es wurde noch keine Buchung erfasst zu der ein Beleg zugeordnet werden könnte</flux:subheading>
        </div>
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

                this.$wire.form.tax = this.maskInput(tax);
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
