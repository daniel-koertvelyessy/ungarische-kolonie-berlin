<div class="space-y-2 lg:space-y-6">
    <flux:heading size="xl">{{ __('members.apply.title') }}</flux:heading>
    <flex:text>{{ __('members.apply.text') }}</flex:text>

    <aside class="p-3 border border-zinc-300 dark:border-zinc-500">
        <flux:heading size="lg">{{ __('members.apply.email.note.header') }}</flux:heading>
        <flux:text>{{ __('members.apply.email.note.content') }}</flux:text>
    </aside>

    <section class="space-y-2 lg:space-y-6">
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


    <form wire:submit="applyMembership">
        <div class="w-full lg:w-3/4 mx-auto">
            <flux:card class="space-y-6 mb-3 lg:mb-6">
                <flux:separator text="{{ __('members.section.person') }}"/>
                <flux:input wire:model="name"
                            label="{{ __('members.name') }}*"
                            required
                />
                <flux:input wire:model="first_name"
                            label="{{ __('members.first_name') }}"
                />


                <flux:input type="date"
                            wire:model="birth_date"
                            wire:blur="checkBirthDate"
                            label="{{ __('members.birth_date') }}"
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
                />
                <flux:input wire:model="city"
                            label="{{ __('members.city') }}"
                />
                <flux:input wire:model="country"
                            label="{{ __('members.country') }}"
                />

                <flux:separator text="{{ __('members.section.phone') }}"/>

                <flux:input wire:model="phone"
                            label="{{ __('members.phone') }}"
                />
                <flux:input wire:model="mobile"
                            label="{{ __('members.mobile') }}"
                />

                <flux:separator text="{{ __('members.section.fees') }}"/>

                <flux:text>{{ __('members.apply.fee.label', ['sum' => \App\Models\Member::feeForHumans() ]) }}</flux:text>

                <flux:checkbox wire:model="is_deducted"
                               label="{{ __('members.apply.discount.label') }}"
                />
                <flux:textarea wire:model="deduction_reason"
                               label="{{ __('members.apply.discount.reason.label') }}"
                />

                <flux:separator text="{{ __('members.section.email') }}"/>
                <flux:text>{{ __('members.apply.email.benefits') }}</flux:text>

                <flux:input wire:model="email" wire:blur="checkEmail"
                            label="{{ __('members.email') }}"
                />

                <flux:checkbox wire:model.live="nomail"
                               label="{{ __('members.apply.email.none') }}"
                />
                @if($nomail)
                    <flux:text>{{ __('members.apply.email.without.text') }}</flux:text>
                @endif
            </flux:card>
            @if(app()->isProduction())
                <x-turnstile wire:model="checkTurnStile" />
            @endif
            @if($nomail)
                <flux:button type="submit"
                             variant="primary"
                             icon="printer"
                >{{ __('members.apply.printAndSubmit') }}</flux:button>
            @else
                <flux:button type="submit"
                             variant="primary"
                             icon="paper-airplane"
                >{{ __('members.apply.checkAndSubmit') }}</flux:button>
            @endif
        </div>


    </form>
    <flux:modal name="validation_error">
        {{ $validation_error }}
    </flux:modal>
</div>
