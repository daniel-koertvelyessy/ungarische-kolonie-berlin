<div>
    <flux:header title="Bildübersicht">

        <flux:button tone="primary" href="{{ route('shared-image.create') }}">
            Neues Bild hochladen
        </flux:button>

        <flux:button
            wire:click="toggleViewMode"
            tone="neutral"
            icon="{{ $viewMode === 'grid' ? 'bars-4' : 'squares-2x2' }}"
            title="Ansicht wechseln"
            size="sm"
        />
    </flux:header>

    <livewire:app.tool.shared-image.index.content :viewMode="$viewMode" :key="'viewmode-'.$viewMode" />
</div>
