<div>
    <header class="py-3 border-b border-zinc-200 mb-6">
        <flux:heading size="xl">Kassenjahr 2025</flux:heading>
    </header>

    <section class="grid grid-cols-1 gap-3 md:grid-cols-2 lg:grid-cols-3 lg:gap-6">

        <flux:card>
            <flux:heading>Belege</flux:heading>
            <section class="space-y-6 my-3">
                <aside>
                    <flux:subheading>Letzen Belege</flux:subheading>
                    @forelse($this->receipts as $key => $receipt)

                        @empty
                        <flux:text size="sm" class="text-orange-500">keine Belege im Buchungsjahr 2025 erfasst</flux:text>
                    @endforelse

                </aside>
                <flux:button variant="primary" href="{{ route('transaction.create') }}">Beleg Einreichen</flux:button>
            </section>
        </flux:card>

        <flux:card>
            <flux:heading>Konten</flux:heading>
            <section class="space-y-6 my-3">
                <flux:card class="bg-teal-50 flex items-center justify-between">
                    <div>
                        <flux:heading>Barkasse</flux:heading>
                        <flux:text>Stand: 2025-02-23</flux:text>
                    </div>
                    <aside>EUR 10.122,12</aside>
                </flux:card>
            </section>
        </flux:card>
        <flux:card>
            <flux:heading>Berichte</flux:heading>
            <section class="space-y-6 my-3">
                <flux:button>Kassensturz</flux:button>
            </section>
        </flux:card>

    </section>

</div>
