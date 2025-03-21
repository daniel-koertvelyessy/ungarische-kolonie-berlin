<footer class="py-16 flex justify-center flex-col items-center text-sm text-black dark:text-white/70">

    <flux:sidebar stashable
                  sticky
                  class="lg:hidden bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700"
    >

        <flux:sidebar.toggle class="lg:hidden"
                             icon="x-mark"
        />
        <flux:navlist variant="outline">
            <flux:navlist.item wire:navigate
                               href="/"
            >{{__('app.home')}}</flux:navlist.item>
            <flux:navlist.item wire:navigate
                               href="{{ route('events.index') }}"
            >{{__('app.events')}}</flux:navlist.item>
            <flux:navlist.item wire:navigate
                               href="{{ route('posts.index') }}"
            >{{__('app.blog')}}</flux:navlist.item>
            <flux:navlist.item wire:navigate
                               href="{{ route('about-us') }}"
            >{{__('app.about-us')}}</flux:navlist.item>
            <flux:navlist.item wire:navigate
                               href="{{ route('members.application') }}"
            >{{__('app.become-member')}}</flux:navlist.item>
            <flux:separator/>
            <flux:navlist.item wire:navigate
                               href="{{ route('imprint') }}"
            >{{__('app.imprint')}}</flux:navlist.item>

            @if (Route::has('login'))

                @auth
                    <flux:navlist.item wire:navigate
                                       href="{{ url('/dashboard') }}"
                    >{{__('app.dashboard')}}</flux:navlist.item>
                @else
                    <flux:navlist.item wire:navigate
                                       href="{{ route('login') }}"
                    >{{__('app.gotologin')}}</flux:navlist.item>
                @endauth

            @endif

            <flux:navlist.group heading="{{__('app.locale')}}"
                                expandable
                                :expanded="false"
            >
                @foreach (\App\Enums\Locale::toArray() as $locale)
                    <flux:navlist.item href="{{url('/lang/'.$locale)}}">{{ strtoupper($locale) }}</flux:navlist.item>
                @endforeach
            </flux:navlist.group>


        </flux:navlist>
    </flux:sidebar>

    <flux:navbar class="hidden lg:flex">

        <flux:navbar.item wire:navigate
                          href="/"
        >{{__('app.home')}}</flux:navbar.item>

        <flux:navbar.item wire:navigate
                          :current="request()->routeIs('events*')"
                          href="{{ route('events.index') }}"
        >{{__('app.events')}}</flux:navbar.item>

        <flux:navbar.item wire:navigate
                          :current="request()->routeIs('posts*')"
                          href="{{ route('posts.index') }}"
        >{{__('app.blog')}}</flux:navbar.item>

        <flux:navbar.item wire:navigate
                          :current="request()->routeIs('about-us')"
                          href="{{ route('about-us') }}"
        >{{__('app.about-us')}}</flux:navbar.item>

        <flux:navbar.item wire:navigate
                          href="{{ route('members.application') }}"
                          :current="request()->routeIs('members*')"
        >{{__('app.become-member')}}</flux:navbar.item>

        <flux:dropdown>
            <flux:navbar.item icon-trailing="chevron-down">{{__('app.locale')}}</flux:navbar.item>

            <flux:navmenu>
                @foreach (\App\Enums\Locale::toArray() as $locale)
                    <flux:navmenu.item wire:navigate
                                       href="{{url('/lang/'.$locale)}}"
                    >
                        <span class="{{ app()->getLocale() === $locale ? 'font-semibold' : 'font-light' }}">
                            {{ strtoupper($locale) }}
                        </span>
                    </flux:navmenu.item>
                @endforeach

            </flux:navmenu>


        </flux:dropdown>
    </flux:navbar>
    <flux:navbar class="hidden lg:flex my-3 lg:my-6">
        <span class="text-zinc-400 mx-3 text-sm">(c) Magyar Kolónia Berlin e. V.</span>

        <x-footer-link link="{{ route('imprint') }}">{{__('app.imprint')}}</x-footer-link>



        @if (Route::has('login'))

            @auth
                <x-footer-link link="{{ route('dashboard') }}">{{__('app.dashboard')}}</x-footer-link>
            @else
                <x-footer-link link="{{ route('login') }}">{{__('app.gotologin')}}</x-footer-link>
            @endauth

        @endif
    </flux:navbar>
</footer>
