<div>

    <form wire:submit="updateAccountData">
        <section class="space-y-6 mb-3">
            <flux:input wire:model="form.name" label="name" />
            <flux:input wire:model="form.number" label="number" />
            <flux:input wire:model="form.institute" label="institute" />
            <flux:input wire:model="form.type" label="type" />
            <flux:input wire:model="form.iban" label="iban" />
            <flux:input wire:model="form.bic" label="bic" />
            <flux:input wire:model="form.starting_amount" label="starting_amount" />
        </section>

        @can('update',\App\Models\Accounting\Account::class)
            <flux:button type="submit" variant="primary" size="sm">Speichern</flux:button>
        @endcan

    </form>

</div>
