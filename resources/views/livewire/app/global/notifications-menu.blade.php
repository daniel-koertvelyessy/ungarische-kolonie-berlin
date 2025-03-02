<div>

    <flux:menu.item icon="bell" badge="{{ $notifications->count() }}">Inbox</flux:menu.item>

   {{-- <flux:dropdown>
        <flux:dropdown.trigger>
            <button class="relative">
                <flux:icon.bell-alert class="w-6 h-6" />
                @if($notifications->count())
                    <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold px-2 rounded-full">
                    {{ $notifications->count() }}
                </span>
                @endif
            </button>
        </flux:dropdown.trigger>

        <flux:dropdown.content>
            <div class="p-2">
                @forelse ($notifications as $notification)
                    <div class="flex justify-between items-center p-2 border-b">
                        <span>{{ $notification->data['message'] ?? 'Neue Benachrichtigung' }}</span>
                        <button wire:click="markAsRead('{{ $notification->id }}')" class="text-blue-500 text-sm">✔</button>
                    </div>
                @empty
                    <p class="p-2 text-gray-500">Keine neuen Benachrichtigungen</p>
                @endforelse
            </div>
        </flux:dropdown.content>
    </flux:dropdown>--}}

</div>
