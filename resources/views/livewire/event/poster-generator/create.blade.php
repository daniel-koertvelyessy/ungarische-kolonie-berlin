<div class="space-y-6">
    <flux:separator text="{{ __('event.poster.separator.text') }}" />

    @if ($event->hasPoster('hu'))
        <img src="{{ $event->getPoster('hu') }}"
             alt="Poster"
             class="w-1/2"
        >
    @endif

    @if ($event->hasPoster('de'))
        <img src="{{ $event->getPoster('de') }}"
             alt="Poster"
             class="w-1/2"
        >
    @endif

    <flux:button wire:click="generateJpeg">Generate JPEG</flux:button>
    <flux:button wire:click="generatePdf">Generate PDF</flux:button>

</div>
