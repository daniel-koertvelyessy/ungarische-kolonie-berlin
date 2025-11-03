<header class="lg:flex justify-between items-center mb-6 gap-3 hidden pb-6">
    <div class="lg:ml-3">
        <a href="/">
            <x-application-logo class="size-26"/>
        </a>
    </div>

    <p class="lg:text-5xl font-semibold text-center">
        <span class="text-shadow-zinc-500 text-shadow-md text-red-700">Magyar</span>
        <span class="text-shadow-zinc-500 text-shadow-md text-white">Kolónia</span>
        <span class="text-shadow-zinc-500 text-shadow-md text-green-700">Berlin</span>
        <span class="text-2xl">e. V.</span><br>
        <span class="text-2xl">1846</span>
    </p>

    <figure>
        <img src="{{ Vite::asset('resources/images/magyar_cim.svg') }}"
             class="h-28  lg:mr-3"
             alt="{{ __('app.magyarcim') }}"
        >
    </figure>
</header>
