<x-login-layout title="{{ __('app.login.title') }}" >

    <flux:card class="space-y-6 max-w-2xl mx-auto mt-10 lg:mt-60">
        <div>
            <flux:heading size="lg">{{ __('app.login.header') }}</flux:heading>
{{--            <flux:subheading>Welcome back!</flux:subheading>--}}
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="space-y-6">
                <flux:input name="email" label="{{ __('app.login.email.label') }}" type="email" required/>

                <flux:field>
                    <div class="mb-3 flex justify-between">
                        <flux:label>{{ __('app.login.password.label') }}</flux:label>
                        <flux:link href="{{ route('password.request') }}" variant="subtle" class="text-sm">{{ __('app.login.forgot_password.label') }}</flux:link>
                    </div>

                    <flux:input name="password" type="password" required />

                    <flux:error name="password" />
                </flux:field>
            </div>

            <div class="space-y-2 mt-6">
                <flux:button type="submit" variant="primary" >{{ __('app.login.btn.login.label') }}</flux:button>
             {{--   @if (Route::has('register'))
                <flux:button variant="ghost" href="{{ route('register') }}" >{{ __('app.login.btn.register.label') }}</flux:button>
                @endif--}}
            </div>
        </form>

    </flux:card>

</x-login-layout>
