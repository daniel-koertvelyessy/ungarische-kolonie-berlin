<section class="space-y-6 my-3 ">

    @forelse(\App\Models\Accounting\CashCount::query()->whereYear('cash_counts.counted_at','2025')->latest()->get() as $counting)

        <flux:card class="flex items-center justify-between">
            <div class="flex-1">
                <flux:heading>{{ $counting->label }}</flux:heading>
                <flux:text>vom: {{ $counting->counted_at->format('Y-m-d') }}</flux:text>
            </div>
            <aside class="font-bold">  {{ $counting->sumString() }}<span class="text-sm ml-2.5">EUR</span></aside>
        </flux:card>
    @empty
        Keine Zählungen erfasst
    @endforelse


</section>

