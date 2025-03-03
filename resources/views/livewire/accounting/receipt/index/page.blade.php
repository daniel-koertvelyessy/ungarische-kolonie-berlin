<div>
<flux:heading size="lg">Belege</flux:heading>

    <nav>

    </nav>


    <section class="grid gap-3 grid-cols-2 lg:grid-cols-3 2xl:grid-cols-6">

        @foreach($this->receipts() as $receipt)
            <flux:card wire:key="$receipt->id">
                Beleg ID
            </flux:card>
        @endforeach

    </section>
</div>
