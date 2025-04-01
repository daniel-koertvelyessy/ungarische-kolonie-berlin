<x-guest-layout title="Register">

    <flux:card class="lg:w-1/2 mx-auto mt-3 lg:mt-20">
        <form method="POST"
              action="{{ route('members.register') }}"
              x-data="passwordStrength()"
        >
            @csrf
            <input type="hidden"
                   name="name"
                   value="{{ $member->name }}"
            >

            <input type="hidden"
                   name="token"
                   value="{{ $token }}"
            >

            <section class="space-y-6">

                <flux:heading size="lg">{{ __('members.register.title') }}</flux:heading>

                <flux:text>{{ __('members.register.password_requirements') }}</flux:text>

                <ul class="text-sm">
                    <li><span :class="checkLength">{{ __('members.register.checkLength') }}</span></li>
                    <li><span :class="checkCapital">{{ __('members.register.checkCapital') }}</span></li>
                    <li><span :class="checkNumbers">{{ __('members.register.checkNumbers') }}</span></li>
                    <li><span :class="checkSpecial">{{ __('members.register.checkSpecial') }}</span></li>
                </ul>

                <flux:input viewable
                            name="password"
                            type="password"
                            required
                            label="{{ __('members.register.password') }}"
                            @input="checkStrength($event.target.value)"
                />


                <flux:input viewable
                            type="password"
                            name="password_confirmation"
                            required
                            label="{{ __('members.register.password_confirm') }}"
                />

                <div class="flex justify-between items-center">
                    <flux:button variant="primary"
                                 type="submit"
                    >{{ __('members.register.submit') }}
                    </flux:button>
                    <span x-text="strengthMessage"
                          :class="strengthClass"
                    ></span>
                </div>


                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    T&C
                @endif


            </section>
            <script>
                document.addEventListener('alpine:init', () => {
                    Alpine.data('passwordStrength', () => ({
                        password: '',
                        strength: 0,
                        strengthMessage: '',
                        strengthClass: '',
                        checkLength: '',
                        checkCapital: '',
                        checkNumbers: '',
                        checkSpecial: '',
                        checkStrength(pwd) {






                            // Grundstärke basierend auf Länge
                            this.strength = pwd.length > 0 ? 1 : 0;

                            // Zusätzliche Punkte für Kriterien
                            if (pwd.length >= 8) {
                                this.strength++;
                                this.checkLength = 'text-green-600'
                            } else {
                                this.checkLength = ''
                            }

                            if (/[A-Z]/.test(pwd)) {
                                this.strength++;
                                this.checkCapital = 'text-green-600'
                            } else {
                                this.checkCapital = ''
                            }
                            if (/[0-9]/.test(pwd)) {
                                this.strength++;
                                this.checkNumbers = 'text-green-600'
                            } else {
                                this.checkNumbers = ''
                            }

                            if (/[^A-Za-z0-9]/.test(pwd)) {
                                this.strength++;
                                this.checkSpecial = 'text-green-600'
                            } else {
                                this.checkSpecial = ''
                            }

                            // Nachricht und Klasse basierend auf Stärke (0-5)
                            if (this.strength === 0) {
                                this.strengthMessage = '';
                                this.strengthClass = '';
                            } else if (this.strength === 1) {
                                this.strengthMessage = 'Sehr schwach';
                                this.strengthClass = 'text-red-500';
                            } else if (this.strength <= 2) {
                                this.strengthMessage = 'Schwach';
                                this.strengthClass = 'text-orange-500';
                            } else if (this.strength === 3) {
                                this.strengthMessage = 'Mittel';
                                this.strengthClass = 'text-yellow-500';
                            } else if (this.strength === 4) {
                                this.strengthMessage = 'Stark';
                                this.strengthClass = 'text-green-500';
                            } else {
                                this.strengthMessage = 'Sehr stark';
                                this.strengthClass = 'text-green-700';
                            }
                            console.log(this.strengthMessage)
                        }
                    }));
                });
            </script>
        </form>
    </flux:card>


    {{--    <x-authentication-card>
            <x-slot name="logo">
                <x-authentication-card-logo />
            </x-slot>

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div>
                    <x-label for="name" value="{{ __('Name') }}" />
                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                </div>

                <div class="mt-4">
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                </div>

                <div class="mt-4">
                    <x-label for="password" value="{{ __('Password') }}" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                </div>

                <div class="mt-4">
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                    <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                </div>

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="mt-4">
                        <x-label for="terms">
                            <div class="flex items-center">
                                <x-checkbox name="terms" id="terms" required />

                                <div class="ms-2">
                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Terms of Service').'</a>',
                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Privacy Policy').'</a>',
                                    ]) !!}
                                </div>
                            </div>
                        </x-label>
                    </div>
                @endif

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-button class="ms-4">
                        {{ __('Register') }}
                    </x-button>
                </div>
            </form>
        </x-authentication-card>--}}
</x-guest-layout>
