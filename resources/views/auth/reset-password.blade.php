<x-guest-layout>

    <flux:card class="space-y-6 max-w-2xl mx-auto">
        <flux:subheading>{{ __('app.password.set.title') }}</flux:subheading>
        <flux:heading>{{ __('app.password.set.text') }}</flux:heading>

        @session('status')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ $value }}
        </div>
        @endsession

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="block">

                <x-label for="email" value="{{ __('app.password.set.email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('app.password.set.new_password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('app.password.set.confirm_password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <flux:button variant="primary" type="submit">
                    {{ __('app.password.set.btn.label') }}
                </flux:button>
            </div>
        </form>
    </flux:card>

</x-guest-layout>
