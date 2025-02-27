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
                            <flux:error name="transaction.id" />
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
            </flux:card>


            <flux:card>

                <section class="flex flex-wrap gap-3">
                    @foreach(\App\Models\Accounting\Receipt::where('transaction_id','=', $form->id)->get() as $key => $receipt )

                        <flux:field wire:key="{{ $key }}"
                                    class="rounded-md border bg-zinc-50"
                        >
                            <img src="/secure-image/{{ $receipt->file_name }}"
                                 class="size-64"
                                 alt="vorschau datei"
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

                @if($event)

                    <section class="space-y-6">
                        <flux:separator text="Besucher"/>

                        <flux:select wire:model.live="selectedMember"
                                     variant="listbox"
                                     searchable
                                     placeholder="Mitglied auswählen ..."
                        >
                            <flux:select.option value="extern">Externer Gast</flux:select.option>
                            @foreach(\App\Models\Membership\Member::select('id', 'name', 'first_name')->get() as $key => $member)
                                <flux:select.option value="{{ $member->id }}">{{ $member->fullName() }}</flux:select.option>
                            @endforeach
                        </flux:select>

                        <input type="hidden"
                               wire:model="visitor_has_member_id"
                        >

                        <flux:field>
                            <flux:input wire:model="visitor_name"
                                        placeholder="Name des Gastes"
                                        clearable
                            />
                            <flux:error name="visitor_name"/>
                        </flux:field>


                        <flux:radio.group wire:model="gender"
                                          label="Geschlecht"
                                          variant="segmented"
                        >
                            @foreach(\App\Enums\Gender::cases() as $gender)
                                <flux:radio value="{{ $gender->value }}"
                                            label="{{ \App\Enums\Gender::value($gender->value) }}"
                                />
                            @endforeach

                        </flux:radio.group>
                    </section>



                    {{--   TODO:: Implement Gästeliste mit Zähler

                            <flux:input wire:model="external_visitor_name"
                                                x-cloak
                                                x-show="$wire.selectedMember === 'extern'"
                                    />

                           <flux:button @click="addVisitor">Hinzufügen</flux:button>



                                 @forelse($visitors as $visitor)

                                        <flux:badge as="button"
                                                    variant="pill"
                                                    icon="minus"
                                        >{{ $visitor }}
                                        </flux:badge>

                                    @empty
                                        Keine Gäste erfasst
                                    @endforelse
                                    @dump($visitors)--}}

                @endif
            </flux:card>
        </div>
        @script
        <script>

            Alpine.data('checkVat', () => {
                return {
                    // setVisitor(event){
                    //     let select = event.target;
                    //
                    //     console.log(select)
                    //     // let selectedName = select.options[select.selectedIndex].text;
                    //     //
                    //     // this.$wire.visitor_name.set(selectedName)
                    //     // this.$wire.visitor_has_member_id = $wire.selectedMember
                    // },
                    addVisitor() {
                        let newVisitor = this.$wire.visitor_name;

                        if (newVisitor && !this.$wire.visitors.includes(newVisitor)) {
                            let updatedVisitors = [...this.$wire.visitors, newVisitor];
                            this.$wire.set('visitors', updatedVisitors);
                            this.$wire.visitor_name = ''
                            this.calcFees()
                        }
                    },
                    calcFees() {

                        let n = this.$wire.visitors.length
                        let entry_fee = this.$wire.entry_fee
                        let entry_fee_discounted = this.$wire.entry_fee_discounted
                        let total = 0

                        this.$wire.form.amount_gross = this.maskInput(n * entry_fee)
                    },

                    updateValuesFromGross() {
                        let gross = this.updateCents($wire.form.amount_gross) / 100; // Convert cents to euros
                        let vat = this.$wire.form.vat;

                        let tax = (gross * vat / 100).toFixed(4); // Correct rounding to 2 decimal places

                        console.log(gross)

                        this.$wire.form.tax = this.maskInput(tax);
                        this.$wire.form.amount_net = (gross - tax).toFixed(4); // Ensure correct rounding

                        this.$wire.form.amount_net = this.maskInput(this.$wire.form.amount_net);
                        this.$wire.form.amount_gross = this.maskInput(gross);
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
