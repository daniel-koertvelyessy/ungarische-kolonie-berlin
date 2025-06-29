<flux:table :paginate="$this->images">
    <flux:table.columns>
        <flux:table.column>Vorschau</flux:table.column>
        <flux:table.column>Beschreibung</flux:table.column>
        <flux:table.column class="hidden lg:table-cell">Autor</flux:table.column>
        <flux:table.column class="hidden lg:table-cell">Hochgeladen am</flux:table.column>
        @if(auth()->user()->isBoardMember())
            <flux:table.column>Status</flux:table.column>
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
                <flux:table.cell>
                    <span class="hidden lg:inline">{{ $image->label }}</span>
                    <aside class="lg:hidden">
                    <flux:text class="text-wrap">{{ $image->label }}</flux:text>
                        <flux:text>{{ $image->author }}</flux:text>
                        <flux:text>{{ $image->created_at->format('d.m.Y H:i') }}</flux:text>
                    </aside>
                </flux:table.cell>
                <flux:table.cell class="hidden lg:table-cell">{{ $image->author }}</flux:table.cell>
                <flux:table.cell class="hidden lg:table-cell">{{ $image->created_at->format('d.m.Y H:i') }}</flux:table.cell>
                @if(auth()->user()->isBoardMember())
                    <flux:table.cell>
                        <flux:dropdown>
                            <flux:button icon="ellipsis-horizontal"
                                         size="sm"
                                         variant="subtle"
                                         inset="top bottom"
                                         aria-label="Optionsmenü"
                            />
                            <flux:menu>
                                @if(!$image->is_approved)
                                    @can('update',$image)
                                        <flux:menu.item wire:click="$parent.approveImage({{ $image->id }})">Freigeben</flux:menu.item>
                                    @endcan
                                @else
                                    <flux:menu.item icon="check-circle" disabled><span class="text-green-700">Freigegeben</span></flux:menu.item>

                                @endif

                                <flux:menu.item icon="arrow-down-tray" wire:click="$parent.downloadImage({{ $image->id }})">Download</flux:menu.item>

                                <flux:menu.separator/>
                                @can('delete',$image)
                                    <flux:menu.item variant="danger"
                                                    icon="trash"
                                                    wire:click="$parent.deleteImage({{ $image->id }})"
                                    >Delete
                                    </flux:menu.item>
                                @endcan
                            </flux:menu>
                        </flux:dropdown>
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
