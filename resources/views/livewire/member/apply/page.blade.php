<div class="space-y-2 lg:space-y-6">
    <flux:heading size="xl">{{ __('members.apply.title') }}</flux:heading>
    <flex:text>{{ __('members.apply.text') }}</flex:text>

    <flux:accordion transition
                    class="bg-white dark:bg-zinc-600 p-2 rounded"
    >
        <flux:accordion.item>
            <flux:accordion.heading>{{ __('members.apply.process') }}</flux:accordion.heading>

            <flux:accordion.content>
                <aside class="p-3 my-3 border border-zinc-300 dark:border-zinc-500">
                    <flux:heading size="lg">{{ __('members.apply.email.note.header') }}</flux:heading>
                    <flux:text>{{ __('members.apply.email.note.content') }}</flux:text>
                </aside>
                <section class="space-y-2 lg:space-y-6 mb-6">
                    <p><span class="font-semibold">{{ __('members.apply.step1.label') }}:</span> {{ __('members.apply.step1.text') }}</p>
                    <p><span class="font-semibold">{{ __('members.apply.step2.label') }}:</span> {{ __('members.apply.step2.text') }}</p>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">

                        <div class="space-y-2 lg:space-y-6">
                            <h3 class="font-semibold">{{ __('members.apply.via.web') }}</h3>
                            <p><span class="font-semibold">{{ __('members.apply.step3a.label') }}:</span> {{ __('members.apply.click.button') }} [{{ __('members.apply.checkAndSubmit') }}].</p>
                            <p><span class="font-semibold">{{ __('members.apply.step4a.label') }}:</span> {{ __('members.apply.step4a.text') }} </p>
                            <p><span class="font-semibold">{{ __('members.apply.step5a.label') }}:</span> {{ __('members.apply.step5a.text') }} </p>
                        </div>

                        <div class="space-y-2 lg:space-y-6">
                            <h3 class="font-semibold">{{ __('members.apply.via.postal') }}</h3>
                            <p><span class="font-semibold">{{ __('members.apply.step3b.label') }}:</span> {{ __('members.apply.click.checkbox') }} [{{ __('members.apply.email.none') }}].</p>
                            <p><span class="font-semibold">{{ __('members.apply.step4b.label') }}:</span> {{ __('members.apply.step4b.text') }}</p>
                            <p><span class="font-semibold">{{ __('members.apply.step5b.label') }}:</span> {{ __('members.apply.step4b.text') }}</p>
                        </div>

                    </div>


                    <p><span class="font-semibold">{{ __('members.apply.step6.label') }}:</span> {{ __('members.apply.step6.text') }}</p>
                    <p><span class="font-semibold">{{ __('members.apply.step7.label') }}:</span> {{ __('members.apply.step7.text') }}</p>
                </section>
            </flux:accordion.content>
        </flux:accordion.item>

    </flux:accordion>


    <livewire:member.create.form application/>

    {{--<form wire:submit="applyMembership">
        <div class="w-full lg:w-3/4 mx-auto">
            <flux:card class="space-y-6 mb-3 lg:mb-6">
                <flux:separator text="{{ __('members.section.person') }}"/>
                <flux:input wire:model="name"
                            label="{{ __('members.name') }}*"
                            autocomplete="family-name"
                            required
                />
                <flux:input wire:model="first_name"
                            label="{{ __('members.first_name') }}"
                            autocomplete="given-name"
                />


                <flux:input type="date"
                            wire:model="birth_date"
                            wire:blur="checkBirthDate"
                            label="{{ __('members.birth_date') }}"
                            autocomplete="bday"
                />

                <flux:radio.group wire:model="locale"
                                  label="{{ __('members.locale') }}"
                                  variant="segmented"
                                  size="sm"
                >
                    @foreach(\App\Enums\Locale::toArray() as $key => $locale)
                        <flux:radio :key
                                    value="{{ $locale }}"
                                    label="{{ \App\Enums\Locale::value($locale)  }}"
                        />
                    @endforeach
                </flux:radio.group>

                <flux:radio.group wire:model="gender"
                                  label="{{ __('members.gender') }}"
                                  variant="segmented"
                                  size="sm"
                >
                    @foreach(\App\Enums\Gender::toArray() as $key => $gender)
                        <flux:radio :key
                                    value="{{ $gender }}"
                        >{{ \App\Enums\Gender::value($gender) }}</flux:radio>
                    @endforeach

                </flux:radio.group>

                <flux:separator text="{{ __('members.section.address') }}"/>

                <flux:textarea wire:model="address"
                               label="{{ __('members.address') }}"
                               autocomplete="street-address"
                />

                <flux:input wire:model="zip"
                            label="{{ __('members.zip') }}"
                            class="w-20"
                            autocomplete="postal-code"
                />
                <flux:input wire:model="city"
                            label="{{ __('members.city') }}"
                            class="grow"
                            autocomplete="address-level1"

                />


                <flux:input wire:model="country"
                            label="{{ __('members.country') }}"
                            autocomplete="country-name"
                />

                <flux:separator text="{{ __('members.section.phone') }}"/>

                <flux:input wire:model="phone"
                            label="{{ __('members.phone') }}"
                            mask="+99 99 99999999"
                            placeholder="+49 30 12345678"
                            autocomplete="tel"
                />
                <flux:input wire:model="mobile"
                            label="{{ __('members.mobile') }}"
                            mask="+99 999 99999999"
                            placeholder="+49 173 12345678"
                            autocomplete="tel"
                />

                <flux:separator text="{{ __('members.section.fees') }}"/>

                <flux:text>{{ __('members.apply.fee.label', ['sum' => \App\Models\Membership\Member::feeForHumans() ]) }}</flux:text>

                <flux:checkbox wire:model="is_deducted"
                               label="{{ __('members.apply.discount.label') }}"
                />
                <flux:textarea wire:model="deduction_reason"
                               label="{{ __('members.apply.discount.reason.label') }}"
                />

                <flux:separator text="{{ __('members.section.email') }}"/>
                <flux:text>{{ __('members.apply.email.benefits') }}</flux:text>

                <flux:input wire:model="email"
                            wire:blur="checkEmail"
                            label="{{ __('members.email') }}"
                            autocomplete="email"
                />

                <flux:checkbox wire:model.live="nomail"
                               label="{{ __('members.apply.email.none') }}"
                />

                <flux:text x-show="$wire.nomail">{{ __('members.apply.email.without.text') }}</flux:text>

            </flux:card>
            --}}{{--            @if(app()->isProduction())
                            <x-turnstile/>
                        @endif--}}{{--

            <flux:button type="submit"
                         variant="primary"
                         icon="printer"
                         x-show="$wire.nomail"
            >{{ __('members.apply.printAndSubmit') }}</flux:button>

            <flux:button type="submit"
                         variant="primary"
                         icon="paper-airplane"
                         x-show="! $wire.nomail"
            >{{ __('members.apply.checkAndSubmit') }}</flux:button>

        </div>


    </form>--}}
    <flux:modal name="validation_error">
        {{ $validation_error }}
    </flux:modal>
</div>
