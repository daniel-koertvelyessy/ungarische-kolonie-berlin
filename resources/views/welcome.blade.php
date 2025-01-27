<x-guest-layout title="{{ __('welcome.title') }}">

    <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
        <article class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
        >

                <div id="docs-card-content" class="w-full"
                >
                    <div class="pt-3 sm:pt-5 lg:pt-0">
                        <h2 class="text-xl font-semibold text-black dark:text-white">{{ __('welcome.events.title') }}</h2>

                        <p class="mt-4 text-sm/relaxed">
                            {{ __('welcome.events.listing') }}
                        </p>
                        @foreach($events as $key => $event)
                            <x-event-item :event="$event"/>
                        @endforeach

                        <flux:button size="sm"
                                     href="{{ route('events') }}"
                                     variant="primary"
                                     icon-trailing="arrow-right-circle"
                        >
                            {{ __('welcome.events.link.label',['num'=>$total]) }}
                        </flux:button>

                    </div>
                </div>

        </article>

        <article class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
        >

            <div class="pt-3 sm:pt-5">
                <h2 class="text-xl font-semibold text-black dark:text-white">{{ __('welcome.mission.title') }}</h2>

                <p class="mt-4 text-sm/relaxed">
                    {{ __('welcome.mission.content') }}
                </p>
            </div>

        </article>

        <article class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
        >


            <div class="pt-3 sm:pt-5">
                <h2 class="text-xl font-semibold text-black dark:text-white">Der Verein</h2>

                <p class="mt-4 text-sm/relaxed">
                    Gegründet 1846 ...
                </p>
            </div>
        </article>


        <article          class="flex items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
        >

            <div class="pt-3 sm:pt-5 space-y-2">
                <h2 class="text-xl font-semibold text-black dark:text-white">Mitglied werden</h2>

                <p class="mt-4 text-sm/relaxed">
                    Werden Teil einer lustigen und unternehmungsreichen Gesellschaft
                </p>
                <flux:button variant="primary"
                             href="{{ route('become-a-member') }}"
                             icon-trailing="user-plus"

                >Jetzt Antrag ausfüllen!</flux:button>
            </div>

        </article>

    </div>

</x-guest-layout>
