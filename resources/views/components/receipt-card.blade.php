@props(['receipt'])

<flux:card wire:key="{{ $receipt->id }}">
    <div x-data="{ loaded: false }" class="flex flex-col gap-2">

        <!-- Image Wrapper -->
        <div class="w-full rounded-t-lg relative min-h-[200px] ">

            <!-- Spinner oder Skeleton -->
            <div
                x-show="!loaded"
                class="absolute inset-0 flex items-center justify-center bg-gray-100 animate-pulse z-10"
            >
                <svg class="w-8 h-8 text-gray-400 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle
                        class="opacity-25"
                        cx="12" cy="12" r="10"
                        stroke="currentColor" stroke-width="4"
                    ></circle>
                    <path
                        class="opacity-75"
                        fill="currentColor"
                        d="M4 12a8 8 0 018-8v8H4z"
                    ></path>
                </svg>
            </div>

            <!-- Bild -->
            <img
                src="{{ route('secure-image.preview', $receipt->file_name) }}"
                alt="{{ $receipt->file_name_original }}"
                class="w-full h-full object-cover transition-opacity duration-300 ease-in-out"
                loading="lazy"
                @load="loaded = true"
                :class="{ 'opacity-0': !loaded, 'opacity-100': loaded }"
            >
        </div>

        <div class="flex flex-col space-y-1.5">
            <flux:button icon-trailing="link" variant="primary" size="sm"
                href="{{ route('secure-download', ['filename' => $receipt->file_name]) }}"
                download="{{ $receipt->file_name_original }}"
            >
                Download
            </flux:button>
            <flux:text>
                {{ $receipt->file_name_original }}
            </flux:text>
            <flux:text>
                {{ format_bytes(Storage::disk('local')->size('accounting/receipts/' . $receipt->file_name)) }}
            </flux:text>
        </div>
    </div>
</flux:card>
