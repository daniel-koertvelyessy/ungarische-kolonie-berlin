<x-guest-layout title="Willkommen">
    <header class="flex justify-between items-center">
        <div>
           <x-application-logo class="size-52" />

        </div>

        <img src="{{ Vite::asset('resources/images/magyar_cim.svg') }}"
             class="h-48"
             alt=""
        >
    </header>
    <div class="mt-6">
        <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
            <a
                href="#"
                id="docs-card"
                class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
            >
                <div class="relative flex items-center gap-6 lg:items-end">
                    <div id="docs-card-content"
                         class="flex items-start gap-6 lg:flex-col"
                    >


                        <div class="pt-3 sm:pt-5 lg:pt-0">
                            <h2 class="text-xl font-semibold text-black dark:text-white">Veranstaltungen</h2>

                            <p class="mt-4 text-sm/relaxed">
                                Aktuelle Liste der Veranstaltungen
                            </p>
                        </div>
                    </div>
                </div>
            </a>

            <a
                href="#"
                class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
            >


                <div class="pt-3 sm:pt-5">
                    <h2 class="text-xl font-semibold text-black dark:text-white">Der Verein</h2>

                    <p class="mt-4 text-sm/relaxed">
                        Gegründet 1846 ...
                    </p>
                </div>
            </a>

            <a
                href="#"
                class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
            >

                <div class="pt-3 sm:pt-5">
                    <h2 class="text-xl font-semibold text-black dark:text-white">Von Ungarn für Ungarn</h2>

                    <p class="mt-4 text-sm/relaxed">
                        Der Verein hilft Ungarn, die in Berlin wohnen oder zu Besuch sind. Unser schwarzes Brett kann von Mitgliedern mit Angeboten und Suchen eingesehen werden.
                    </p>
                </div>

            </a>
            <a
                href="#"
                class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
            >

                <div class="pt-3 sm:pt-5">
                    <h2 class="text-xl font-semibold text-black dark:text-white">Mitglied werden</h2>

                    <p class="mt-4 text-sm/relaxed">
                        Werden Teil einer lustigen und unternehmungsreichen Gesellschaft
                    </p>
                </div>

            </a>

        </div>
    </div>
</x-guest-layout>
