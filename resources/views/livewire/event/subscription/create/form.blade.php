<div class="pt-6 space-y-6">
    @guest
        <flux:heading>{{ __('event.subscription.title') }}</flux:heading>
        <flux:text>{{ __('event.subscription.text') }}</flux:text>
        <form wire:submit="subscribe">
            <section class="space-y-6">
                <flux:input wire:model="name"
                            required
                            badge="{{ __('app.form.field.required') }}"
                            label="{{ __('event.subscription.name') }}"
                />
                <flux:input type="email"
                            required
                            wire:model="email"
                            badge="{{ __('app.form.field.required') }}"
                            label="{{ __('event.subscription.email') }}"
                />
                <flux:accordion>
                    <flux:accordion.item>
                        <flux:accordion.heading>{{ __('event.subscription.optional_section') }}</flux:accordion.heading>
                        <flux:accordion.content class="space-y-6 mt-3 lg:mt-6">
                            <flux:input type="tel"
                                        wire:model="phone"
                                        label="{{ __('event.subscription.phone') }}"
                            />
                            <flux:textarea wire:model="remarks"
                                           rows="auto"
                                           label="{{ __('event.subscription.remarks') }}"
                            />

                            <section class="flex items-center justify-start gap-3">
                                <flux:switch wire:model="bringsGuests"
                                             label="{{ __('event.subscription.bringFriends') }}"
                                             class="grow"
                                />
                                <flux:input wire:model="amountGuests"
                                            min="0"
                                            max="10"
                                            class="flex-1"
                                            placeholder="{{ __('event.subscription.amountGuests') }}"
                                            x-show="$wire.bringsGuests"
                                />
                            </section>

                            <flux:text>{{ __('event.subscription.consent') }}</flux:text>
                            <flux:switch wire:model="consentNotification"
                                         label="{{ __('event.subscription.consent.label') }}"
                                         class="grow"
                            />
                        </flux:accordion.content>
                    </flux:accordion.item>
                </flux:accordion>


                <flux:button type="submit"
                             icon-trailing="user-plus"
                             variant="primary"
                >{{ __('event.subscription.submit-button.label') }}</flux:button>
            </section>
        </form>
        <flux:subheading size="lg">{{ __('event.subscription.disclaimer.header') }}</flux:subheading>
        <flux:text>{{ __('event.subscription.disclaimer.body') }}</flux:text>
    @endguest

    @auth
        <flux:heading>{{ __('event.backend.subscription.title') }}</flux:heading>
        <form wire:submit="subscribe">
            <section class="space-y-6">
                <flux:input wire:model="name"
                            label="{{ __('event.subscription.name') }}"
                />
                <flux:input type="email"
                            wire:model="email"
                            label="{{ __('event.subscription.email') }}"
                />
                <flux:accordion>
                    <flux:accordion.item>
                        <flux:accordion.heading>Mehr</flux:accordion.heading>
                        <flux:accordion.content class="space-y-6">
                <flux:input type="tel"
                            wire:model="phone"
                            label="{{ __('event.subscription.phone') }}"
                />
                <flux:textarea wire:model="remarks"
                               rows="auto"
                               label="{{ __('event.subscription.remarks') }}"
                />
                <flux:input wire:model="amountGuests"
                            min="0"
                            max="10"
                            class="flex-1"
                            label="{{ __('event.subscription.amountGuests') }}"
                />
                <flux:switch wire:model="consentNotification"
                             label="{{ __('event.backend.subscription.consent.label') }}"
                             class="grow"
                />
                <flux:switch wire:model="sendNotification"
                             label="{{ __('event.backend.subscription.sendNotification.label') }}"
                             class="grow"
                />
                        </flux:accordion.content>
                        </flux:accordion.item>
                    </flux:accordion>
                <flux:button type="submit"
                             icon-trailing="user-plus"
                             variant="primary"
                >{{ __('event.backend.subscription.submit-button.label') }}</flux:button>
            </section>
        </form>
    @endauth
</div>
