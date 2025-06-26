<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
    @forelse($this->images as $image)
        <flux:card class="p-2"
                   wire:key="image-{{ $image->id }}"
        >
            <div class="aspect-video overflow-hidden rounded-xl">

                @if($image->thumbnail_path)
                    <img src="{{ route('secure-image.category', ['category' => 'shared-images/thumbs', 'filename' => basename($image->thumbnail_path)]) }}"
                         alt="{{ $image->label }}"
                         class="w-full h-full object-contain" />
                @else
                    <div class="w-full h-full flex items-center justify-center text-sm text-gray-400">
                        Keine Vorschau
                    </div>
                @endif
            </div>

            <div class="mt-2 space-y-1">
                <div class="font-medium text-sm truncate">{{ $image->label }}</div>
                <div class="text-xs text-gray-500">von {{ $image->author }}</div>
                <div class="text-xs text-gray-500">{{ $image->created_at->format('d.m.Y H:i') }}</div>

                @if(auth()->user()->isBoardMember())
                    <aside class="flex justify-between items-center">
                        <div class="pt-1">
                            @if(!$image->is_approved)
                                <flux:button wire:click="$parent.approveImage({{ $image->id }})"
                                             tone="positive"
                                             size="sm"
                                >
                                    Freigeben
                                </flux:button>
                            @else
                                <span class="text-green-600 text-xs font-semibold">Freigegeben</span>
                            @endif
                        </div>
                        <flux:button size="xs" variant="danger">Löschen</flux:button>
                    </aside>
                @endif
            </div>
        </flux:card>
    @empty
        keine Bilde da
    @endforelse
</div>
