<div class="space-y-6">
    <flux:separator text="{{ __('event.poster.separator.text') }}" />

    <section class="flex gap-3">
        @foreach(\App\Enums\Locale::cases() as $locale)
            @if ($event->hasPoster($locale->value))
                <img src="{{ $event->getPoster($locale->value) }}"
                     alt="Poster {{ $locale->value }}"
                     class="w-1/2"
                >
            @endif
        @endforeach
    </section>

    <section class="flex gap-3">
        @foreach(\App\Enums\Locale::cases() as $locale)
            @if ($event->hasPoster($locale->value,'pdf'))

                <flux:button variant="filled" href="{{ $event->getPoster($locale->value,'pdf') }}" download="">PDF - {{ $locale->value }}</flux:button>

            @endif
        @endforeach
    </section>



    <flux:button wire:click="generateJpeg">Generate JPEG</flux:button>
    <flux:button wire:click="generatePdf">Generate PDF</flux:button>

</div>
