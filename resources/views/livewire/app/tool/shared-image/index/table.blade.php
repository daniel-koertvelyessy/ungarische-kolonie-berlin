<flux:table :paginate="$this->images">
    <flux:table.columns>
        <flux:table.column>Vorschau</flux:table.column>
        <flux:table.column>Beschreibung</flux:table.column>
        <flux:table.column>Autor</flux:table.column>
        <flux:table.column>Hochgeladen am</flux:table.column>
        @if(auth()->user()->isBoardMember())
            <flux:table.column>Freigabe</flux:table.column>
        @endif
    </flux:table.columns>
    <flux:table.rows>
        @forelse($this->images as $image)
            <flux:table.row :key="$image->id">
                <flux:table.cell>
                    @if($image->thumbnail_path)
                        <img src="{{ route('secure-image.category', ['filename' => basename($image->thumbnail_path), 'category' => 'shared-images/thumbs'])}}"
                             alt="Thumbnail"
                             class="w-16 h-16 object-cover rounded"
                        />
                    @else
                        <span>Keine Vorschau</span>
                    @endif
                </flux:table.cell>
                <flux:table.cell>{{ $image->label }}</flux:table.cell>
                <flux:table.cell>{{ $image->author }}</flux:table.cell>
                <flux:table.cell>{{ $image->created_at->format('d.m.Y H:i') }}</flux:table.cell>
                @if(auth()->user()->isBoardMember())
                    <flux:table.cell>
                        @if(!$image->is_approved)
                            <flux:button wire:click="approveImage({{ $image->id }})"
                                         tone="positive"
                                         size="sm"
                            >
                                Freigeben
                            </flux:button>
                        @else
                            <span class="text-green-600 font-semibold">Freigegeben</span>
                        @endif
                    </flux:table.cell>
                @endif
            </flux:table.row>
        @empty
            <flux:table.row>
                <flux:table.cell>Keine Bilder da</flux:table.cell>
            </flux:table.row>
        @endforelse
    </flux:table.rows>
</flux:table>
