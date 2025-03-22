@php use App\Enums\TransactionStatus; @endphp
@php use App\Models\Accounting\Account; @endphp
@php use App\Models\Accounting\BookingAccount; @endphp
<div>
    <form wire:submit="updateBookingStatus"
          class="space-y-6"
    >
        <input type="hidden"
               wire:model="form.id"
        >
        <flux:heading size="lg">Buchung zuordnen</flux:heading>
        <flux:radio.group wire:model="form.status"
                          label="Status setzen"
                          variant="segmented"
        >
            @foreach(TransactionStatus::cases() as $key => $type)
                <flux:radio :key
                            value="{{ $type->value }}"
                >{{ $type->value }}</flux:radio>
            @endforeach
        </flux:radio.group>

        <flux:select placeholder="SKR Konto"
                     label="SKR Konto zuordnen"
                     wire:model.live="form.booking_account_id"
                     size="sm"
                     variant="listbox"
                     clearable
                     searchable
        >
            @can('create', Account::class)
                <flux:select.option value="new">Neues SKR 49 Buchungskonto</flux:select.option>
            @endcan
            @foreach(BookingAccount::select('id', 'label', 'number')->get() as $key => $account)
                <flux:select.option :key
                                    value="{{ $account->id }}"
                >{{ $account->number }} - {{ $account->label }}</flux:select.option>
            @endforeach
        </flux:select>
        <flux:button type="submit"
                     variant="primary"
        >Buchung abschließen
        </flux:button>


    </form>

</div>
