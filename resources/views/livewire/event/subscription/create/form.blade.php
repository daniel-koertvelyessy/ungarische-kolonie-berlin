<div class="pt-6 space-y-6">
    <flux:heading>{{ __('event.subscription.title') }}</flux:heading>
    <flux:text>{{ __('event.subscription.text') }}</flux:text>
    <form wire:submit="subscribe">
        <section class="space-y-6">
            <flux:input wire:model="name" label="Name" />
            <flux:input type="email" wire:model="email" label="{{ __('members.email') }}" />
            <flux:input type="tel" wire:model="phone" label="Telefon (optional)" />
            <flux:textarea wire:model="remarks" rows="auto" label="Anmerkungen" />

            <section class="flex items-center justify-start gap-3">
                <flux:switch wire:model="bringsGuests" label="Ich bringe Gäset mit" class="grow"/>
                <flux:input wire:model="amountGuests" min="1" max="10" placeholder="Anzahl der Gäste" x-show="$wire.bringsGuests" class="flex-1"/>
            </section>

            <flux:text>{{ __('event.subscription.consent') }}</flux:text>
                <flux:switch wire:model="consentNotification" label="{{ __('event.subscription.consent.label') }}" class="grow"/>




            <flux:button type="submit" icon-trailing="user-plus" variant="primary">{{ __('event.subscription.submit-button.label') }}</flux:button>
        </section>
    </form>


    <flux:subheading size="lg">{{ __('event.subscription.disclaimer.header') }}</flux:subheading>
    <flux:text>{{ __('event.subscription.disclaimer.body') }}</flux:text>

</div>
