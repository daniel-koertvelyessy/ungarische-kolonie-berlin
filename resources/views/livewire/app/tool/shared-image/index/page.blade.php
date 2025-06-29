<div>
    <flux:heading size="lg">Bildergallerie</flux:heading>
    <nav class="flex gap-3 my-3">

        <flux:button variant="primary" size="sm" href="{{ route('shared-image.create') }}">
            Neues Bild hochladen
        </flux:button>

        <flux:button
            wire:click="toggleViewMode"
            tone="neutral"
            icon="{{ $viewMode === 'grid' ? 'bars-4' : 'squares-2x2' }}"
            title="Ansicht wechseln"
            size="sm"
        />

    </nav>

    <livewire:app.tool.shared-image.index.content :viewMode="$viewMode" :key="'viewmode-'.$viewMode" />

</div>
