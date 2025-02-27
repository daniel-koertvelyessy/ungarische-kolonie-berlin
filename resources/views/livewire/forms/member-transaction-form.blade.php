<div>
@can('create', \App\Models\Membership\MemberTransaction::class)
    <form wire:submit="addTransaction" x-data="checkVat">
        <input type="hidden" wire:model="member_id">
        <section class="space-y-6">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
            <flux:input type="date" wire:model="date" label="date" />
                <flux:input wire:model="amount"
                            x-mask:dynamic="$money($input, ',', '.')"
                            label="Betrag"
                            @change="formatAmount"
                />
            </div>

            <!--
             Zahlungskonto wie Barkasse, Bankkonto oder PayPal
             -->
            <flux:field>
                <flux:select wire:model="account_id"
                             size="sm"
                             placeholder="Zahlungskonto z.B. Barkasse, Bankkonto usw"
                             variant="listbox"
                             clearable
                             searchable
                >

                    @foreach(\App\Models\Accounting\Account::select('id', 'name')->get() as $key => $account)
                        <flux:select.option :key
                                     value="{{ $account->id }}"
                        >{{ $account->name }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flex:flux:error name="form.account_id"/>
            </flux:field>
            <!--
Buchungskonto nach SKR 49
-->
            <flux:select placeholder="SKR Konto"
                         wire:model="booking_account_id"
                         size="sm"
                         variant="listbox"
                         clearable
                         searchable
            >
                @foreach(\App\Models\Accounting\BookingAccount::select('id', 'label', 'number')->get() as $key => $account)
                    <flux:select.option :key
                                 value="{{ $account->id }}"
                    >{{ $account->number }} - {{ $account->label }}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:input wire:model="label" label="Text" required />

            <flux:field>
                <flux:label>Veranstaltung zuordnen (optional)</flux:label>
                <flux:select wire:model="event_id" variant="listbox" searchable clearable placeholder="Veranstaltung wählen">
                    @foreach($events as $key => $event)
                        <flux:select.option value="{{ $event->id }}">{{$event->title['de']}}</flux:select.option>
                    @endforeach
                </flux:select>
            </flux:field>



            <flux:button variant="primary" type="submit">Erfassen</flux:button>
        </section>
    </form>
@endcan
</div>
@script


<script>
    Alpine.data('checkVat', () => {
        return {
            formatAmount(){
                let net = this.updateCents(this.$wire.amount) / 100;
                this.$wire.amount = this.maskInput(net)
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
        }})
</script>
@endscript
