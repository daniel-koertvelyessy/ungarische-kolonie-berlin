<div>
@if(! app()->isProduction())
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    @endif
    <form wire:submit="store">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
            <flux:card class="space-y-6 mb-3 lg:mb-6">
                <flux:separator text="{{ __('members.section.person') }}"/>
                <flux:input wire:model="form.name"
                            label="{{ __('members.name') }}*"
                            autocomplete="family-name"
                            required
                />
                <flux:input wire:model="form.first_name"
                            label="{{ __('members.first_name') }}"
                            autocomplete="given-name"
                />


                <flux:accordion transition
                                expanded
                >
                    <flux:accordion.item heading="{{ __('members.accordion.optionals.label') }}">

                        <section class="space-y-6 mt-3">
                            <flux:text>{{ __('members.optional-data.text') }}</flux:text>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                                <flux:input type="date"
                                            wire:model="form.birth_date"
                                            wire:blur="checkBirthDate"
                                            label="{{ __('members.birth_date') }}"
                                            autocomplete="bday"
                                />
                                <flux:input wire:model="form.birth_place"
                                            label="{{ __('members.birth_place') }}"
                                            autocomplete="address-level1"
                                />
                            </div>


                            <flux:radio.group wire:model="form.locale"
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

                            <flux:radio.group wire:model="form.gender"
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


                            <flux:radio.group wire:model="form.family_status"
                                              label="{{ __('members.familystatus.label') }}"
                                              variant="segmented"
                                              size="sm"
                            >
                                @foreach(\App\Enums\MemberFamilyStatus::cases() as $key => $status)
                                    <flux:radio :key
                                                value="{{ $status->value }}"
                                    >{{ \App\Enums\MemberFamilyStatus::value($status->value) }}</flux:radio>
                                @endforeach
                            </flux:radio.group>
                        </section>

                    </flux:accordion.item>
                </flux:accordion>
                <flux:separator text="{{ __('members.section.address') }}"/>

                <flux:textarea wire:model="form.address"
                               label="{{ __('members.address') }}"
                               autocomplete="street-address"
                />

                <flux:input wire:model="form.zip"
                            label="{{ __('members.zip') }}"
                            class="w-20"
                            autocomplete="postal-code"
                />
                <flux:input wire:model="form.city"
                            label="{{ __('members.city') }}"
                            class="grow"
                            autocomplete="address-level1"

                />


                <flux:input wire:model="form.country"
                            label="{{ __('members.country') }}"
                            autocomplete="country-name"
                />

            </flux:card>
            <flux:card class="space-y-6 mb-3 lg:mb-6">

                <flux:separator text="{{ __('members.section.phone') }}"/>

                <flux:input wire:model="form.phone"
                            label="{{ __('members.phone') }}"
                            mask="+99 99 99999999"
                            placeholder="+49 30 12345678"
                            autocomplete="tel"
                />
                <flux:input wire:model="form.mobile"
                            label="{{ __('members.mobile') }}"
                            mask="+99 999 99999999"
                            placeholder="+49 173 12345678"
                            autocomplete="tel"
                />

                <flux:separator text="{{ __('members.section.fees') }}"/>

                <flux:text>{{ __('members.apply.fee.label', ['sum' => \App\Models\Membership\Member::feeForHumans() ]) }}</flux:text>

                <flux:checkbox wire:model="form.is_deducted"
                               label="{{ __('members.apply.discount.label') }}"
                />
                <flux:textarea wire:model="form.deduction_reason"
                               label="{{ __('members.apply.discount.reason.label') }}"
                />

                <flux:separator text="{{ __('members.section.email') }}"/>
                <flux:text>{{ __('members.apply.email.benefits') }}</flux:text>


                <flux:input wire:model="form.email"
                            wire:blur="checkEmail"
                            label="{{ __('members.email') }}"
                            autocomplete="email"
                />

                <flux:checkbox wire:model.live="nomail"
                               label="{{ __('members.apply.email.none') }}"
                />

                <flux:text x-show="$wire.nomail">{{ __('members.apply.email.without.text') }}</flux:text>

                @can('create', \App\Models\Membership\Member::class)

                    <flux:separator text="{{ __('members.section.admins') }}"/>

                    <flux:input type="date"
                                wire:model="form.applied_at"
                                label="{{ __('members.date.applied_at') }}"
                    />

                    <flux:radio.group wire:model="form.type"
                                      label="{{ __('members.type') }}"
                                      variant="segmented"
                    >
                        @foreach(\App\Enums\MemberType::cases() as $key => $type)
                            <flux:radio :key
                                        value="{{ $type->value }}"
                            >{{ \App\Enums\MemberType::value($type->value) }}</flux:radio>
                        @endforeach

                    </flux:radio.group>

                @else
                    <input type="hidden" wire:model="form.applied_at">
                @endcan

            </flux:card>


        </div>

        @if(app()->isProduction())
            <x-turnstile/>
        @endif

        @if($application)
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
        @else

            <flux:button variant="primary" type="submit">Mitglied anlegen</flux:button>
        @endif
    </form>
</div>





