<div class="pt-6 lg:pt-9">


    <div x-data="checkVat">
        <input type="hidden"
               wire:model="form.id"
        >
        <div class="grid grid-cols-1 gap-3 lg:grid-cols-2 lg:gap-6">

            <flux:card>
                <form>
                    <section class="space-y-6">
                        <section class="grid grid-cols-1 lg:grid-cols-2 gap-3">
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
                        </section>

                        <flux:separator text="Konten"/>

                        <section class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                            <flux:field>
                                <!--
                                Zahlungskonto wie Barkasse, Bankkonto oder PayPal
                                -->
                                <flux:button.group>
                                    <flux:select wire:model="form.account_id"
                                                 size="sm"
                                                 placeholder="Zahlungskonto z.B. Barkasse, Bankkonto usw"
                                                 variant="listbox"
                                                 clearable
                                                 searchable
                                    >
                                        @can('create', \App\Models\Accounting\Account::class)
                                            <flux:select.option value="new">Neues Zahlungskonto</flux:select.option>
                                        @endcan
                                        @foreach($this->accounts as $key => $account)
                                            <flux:select.option :key
                                                                value="{{ $account->id }}"
                                            >{{ $account->name }}</flux:select.option>
                                        @endforeach
                                    </flux:select>
                                    @can('create', \App\Models\Accounting\Account::class)
                                        <flux:modal.trigger name="add-account-modal"
                                                            x-cloak
                                                            x-show="$wire.form.account_id === 'new'"
                                        >
                                            <flux:button size="sm"
                                                         variant="primary"
                                                         icon-trailing="plus"
                                            >anlegen
                                            </flux:button>
                                        </flux:modal.trigger>
                                    @endcan

                                </flux:button.group>
                                <flux:error name="form.account_id"/>
                            </flux:field>
                            <!--
            Buchungskonto nach SKR 49
            -->
                            <flux:button.group>
                                <flux:select placeholder="SKR 49 Konto"
                                             wire:model="form.booking_account_id"
                                             size="sm"
                                             variant="listbox"
                                             clearable
                                             searchable
                                >
                                    @can('create', \App\Models\Accounting\Account::class)
                                        <flux:select.option value="new">Neues Buchungskonto</flux:select.option>
                                    @endcan
                                    @foreach($this->booking_accounts as $key => $account)
                                        <flux:select.option :key
                                                            value="{{ $account->id }}"
                                        >{{ $account->number }} - {{ $account->label }}</flux:select.option>
                                    @endforeach
                                </flux:select>

                                @can('create', \App\Models\Accounting\Account::class)
                                    <flux:modal.trigger name="add-booking-account-modal"
                                                        x-cloak
                                                        x-show="$wire.form.booking_account_id === 'new'"
                                    >
                                        <flux:button size="sm"
                                                     variant="primary"
                                                     icon-trailing="plus"
                                        >anlegen
                                        </flux:button>
                                    </flux:modal.trigger>
                                @endcan

                            </flux:button.group>
                        </section>


                        <flux:separator text="Beträge"/>

                        <section class="grid grid-cols-1 lg:grid-cols-4 gap-3">
                            <flux:input wire:model="form.amount_gross"
                                        x-mask:dynamic="$money($input, ',', '.')"
                                        label="Brutto"
                                        @change="updateValuesFromGross"
                            />

                            <flux:input wire:model="form.vat"
                                        label="MWSt [%]"
                                        @change="updateValuesFromGross"
                            />

                            <flux:input wire:model="form.tax"
                                        x-mask:dynamic="$money($input, ',', '.')"
                                        @changed="updateValuesFromGross"
                                        label="MWSt [EUR]"
                                        variant="filled"
                            />

                            <flux:input wire:model="form.amount_net"
                                        x-mask:dynamic="$money($input, ',', '.')"
                                        label="Netto"
                                        @change="updateValuesFromNet"
                            />
                        </section>

                        <flux:separator text="Texte"/>
                        <section class="grid grid-cols-1 lg:grid-cols-4 gap-3">

                            <div class="lg:col-span-2">
                                <flux:input label="Bezeichnung"
                                            wire:model="form.label"
                                />
                            </div>
                            <div class="lg:col-span-2">
                                <flux:input label="Referenz"
                                            wire:model.live.blur="form.reference"
                                />
                            </div>

                            <div class="lg:col-span-1">
                                <flux:input label="Datum"
                                            class="lg:col-span-1"
                                            type="date"
                                            wire:model="form.date"
                                />
                            </div>
                            <div class="lg:col-span-3">
                                <flux:input label="Beschreibung"
                                            wire:model="form.description"
                                />
                            </div>
                        </section>

                        <div class="flex gap-3">


                            <flux:spacer/>
                            <flux:error name="transaction.id"/>
                            <flux:button wire:click="resetTransactionForm">Neue Buchung anfangen</flux:button>
                            @if(isset($event))
                                <flux:button wire:click="submitEventTransaction"
                                             variant="primary"
                                >Event-Buchung speichern
                                </flux:button>
                            @elseif(isset($member))
                                <flux:button wire:click="submitMemberTransaction"
                                             variant="primary"
                                >Mitglied-Buchung speichern
                                </flux:button>
                            @else
                                <flux:button wire:click="submitTransaction"
                                             variant="primary"
                                >Buchung speichern
                                </flux:button>
                            @endif

                        </div>
                    </section>
                </form>

                <x-debug/>
            </flux:card>


            <flux:card>

                <section class="flex flex-wrap gap-3">
                    @foreach(\App\Models\Accounting\Receipt::query()->where('transaction_id','=', $form->id)->get() as $key => $receipt )

                        <flux:field wire:key="{{ $key }}"
                                    class="rounded-md border bg-zinc-50"
                        >
{{--                            <img src="/backend/secure-image/{{ $receipt->getPreviewUrl($receipt->file_name) }}"--}}
{{--                                 class="size-64"--}}
{{--                                 alt="vorschau datei"--}}
{{--                            />--}}
                            <img src="{{ $receipt->getPreviewUrl() }}"
                                 class="size-64 object-contain"
                                 alt="Vorschau Datei"
                            />
                            <flux:button variant="danger"
                                         size="sm"
                                         icon-trailing="trash"
                                         wire:click="deleteFile({{$receipt->id}})"
                            >Beleg löschen
                            </flux:button>
                        </flux:field>

                    @endforeach


                </section>
                <flux:separator text="Neuen Beleg anhängen"/>
                <section class="grow">
                    <form wire:submit="submitReceipt"
                          class="space-y-6"
                    >

                        <div x-data="{ dragOver: false }"
                             x-on:dragover.prevent="dragOver = true"
                             x-on:dragleave="dragOver = false"
                             x-on:drop.prevent="dragOver = false; handleFileDrop($event)"
                             class="relative block w-full rounded-lg border-2 border-dashed p-12 text-center"
                             :class="{ 'border-gray-400 bg-gray-100': dragOver, 'border-gray-300': !dragOver }"
                        >

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
                            <flux:error name="receiptForm.file_name"/>
                        </div>
                        @if($form->id)
                            <flux:spacer/>

                            <flux:button type="submit"
                                         variant="primary"
                            >weiteren Beleg hochladen
                            </flux:button>
                        @endif
                    </form>
                </section>

            </flux:card>
        </div>
        @script
        <script>

            Alpine.data('checkVat', () => {
                return {
                    updateValuesFromGross() {
                        // Parse gross amount (in formatted string, e.g., "11,96") to cents
                        let grossCents = this.updateCents(this.$wire.form.amount_gross);
                        let vat = parseFloat(this.$wire.form.vat) || 0; // VAT percentage, e.g., 19

                        // Calculate tax (VAT amount) in cents: tax = gross * vat / (100 + vat)
                        let taxCents = Math.round((grossCents * vat) / (100 + vat));
                        // Calculate net amount in cents: net = gross - tax
                        let netCents = grossCents - taxCents;

                        // Format back to decimal strings for display
                        this.$wire.form.tax = this.maskInput(taxCents / 100);
                        this.$wire.form.amount_net = this.maskInput(netCents / 100);
                        this.$wire.form.amount_gross = this.maskInput(grossCents / 100);
                    },

                    updateValuesFromNet() {
                        // Parse net amount (in formatted string, e.g., "9,69") to cents
                        let netCents = this.updateCents(this.$wire.form.amount_net);
                        let vat = parseFloat(this.$wire.form.vat) || 0; // VAT percentage, e.g., 19

                        // Calculate gross amount in cents: gross = net * (1 + vat/100)
                        let grossCents = Math.round(netCents * (100 + vat) / 100);
                        // Calculate tax in cents: tax = gross - net
                        let taxCents = grossCents - netCents;

                        // Format back to decimal strings for display
                        this.$wire.form.tax = this.maskInput(taxCents / 100);
                        this.$wire.form.amount_gross = this.maskInput(grossCents / 100);
                        this.$wire.form.amount_net = this.maskInput(netCents / 100);
                    },

                    updateCents(formattedValue) {
                        // Convert formatted string (e.g., "11,96") to cents
                        let value = (formattedValue || '0')
                            .replace(/[^\d,]/g, '')  // Remove non-numeric characters except comma
                            .replace(',', '.');      // Convert comma to dot for decimal
                        let floatValue = parseFloat(value) || 0;
                        return Math.round(floatValue * 100); // Convert to cents and round
                    },

                    maskInput(value) {
                        // Format number to German decimal format (e.g., 11.96 -> "11,96")
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
        @script
        <script>
            function handleFileDrop(event) {
                let file = event.dataTransfer.files[0];
                if (file) {
                    Livewire.emit('fileDropped', file);
                }
            }
        </script>
        @endscript
    </div>

    <aside>
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
                            <flux:select.option value="{{ $type->value }}"
                            >{{ $type->value }}</flux:select.option>
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

                <div class="flex justify-between items-center flex-col sm:flex-row gap-3">

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
                            <flux:select.option value="{{ $type->value }}"
                            >{{ $type->value }}</flux:select.option>
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

                <div class="flex justify-between items-center flex-col sm:flex-row gap-3">
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
    </aside>

</div>
