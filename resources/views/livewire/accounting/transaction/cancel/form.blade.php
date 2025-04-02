<div>
    <form wire:submit="cancel"
          class="space-y-6"
    >

        <input type="hidden"
               wire:model="form.transaction_id"
        >
        <flux:textarea wire:model="form.reason"
                       label="{{ __('transaction.cancel-transaction-modal.reason.label') }}"
        />

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

        <flux:button variant="danger"
                     type="submit"
        >{{ __('transaction.cancel-transaction-modal.btn.submit.label') }}</flux:button>

    </form>

</div>
