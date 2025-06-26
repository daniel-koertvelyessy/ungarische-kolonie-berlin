<div>
    @if($viewMode === 'table')
        <livewire:app.tool.shared-image.index.table :images="$images" />
    @else
        <livewire:app.tool.shared-image.index.grid :images="$images" />
    @endif
</div>
