<x-guest-layout title="{{ __('app.password.reset.title') }}">

    <flux:card class="space-y-6 max-w-2xl mx-auto">
        <flux:subheading>{{ __('app.password.reset.title') }}</flux:subheading>
        <flux:heading>{{ __('app.password.reset.text') }}</flux:heading>

        @session('status')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ $value }}
        </div>
        @endsession

        <x-validation-errors class="mb-4"/>

        <form method="POST"
              action="{{ route('password.email') }}"
        >
            @csrf

            <div class="block">
                <x-label for="email"
                         value="{{ __('app.password.reset.email.label') }}"
                />
                <x-input id="email"
                         class="block mt-1 w-full"
                         type="email"
                         name="email"
                         :value="old('email')"
                         required
                         autofocus
                         autocomplete="username"
                />
            </div>

            <div class="flex items-center justify-end mt-4">
                <flux:button variant="primary" type="submit">
                    {{ __('app.password.reset.btn.label') }}
                </flux:button>
            </div>
        </form>
    </flux:card>
</x-guest-layout>
