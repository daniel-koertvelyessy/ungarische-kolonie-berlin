<div class="p-6 space-y-6">
    <h2 class="text-lg font-bold mb-4">Import Users</h2>

    {{-- File Upload --}}
    <flux:input type="file"
           wire:model="jsonFile"
           class="mb-4"
    />
    @error('jsonFile') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

    {{-- OR Manual JSON Input --}}
    <flux:textarea wire:model.lazy="jsonText"
              rows="6"
              class="w-full border p-2"
    ></flux:textarea>
    @error('jsonText') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

    {{-- Editable Parsed Data Preview --}}
    @if(!empty($parsedUsers))
        <div class="mt-4">
            <h3 class="font-bold mb-2">Review and Edit:</h3>

            <div class="overflow-auto max-h-96">
                @foreach ($parsedUsers as $index => $user)
                    <div class="grid grid-cols-3 gap-4 mb-2">
                        {{-- First Name --}}
                        <div>
                            <label class="text-sm font-semibold">First Name:</label>
                            <input type="text"
                                   wire:model="parsedUsers.{{ $index }}.first_name"
                                   class="border p-2 w-full"
                            />
                            @error("parsedUsers.$index.first_name")
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Last Name --}}
                        <div>
                            <label class="text-sm font-semibold">Last Name:</label>
                            <input type="text"
                                   wire:model="parsedUsers.{{ $index }}.name"
                                   class="border p-2 w-full"
                            />
                            @error("parsedUsers.$index.name")
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="text-sm font-semibold">Email:</label>
                            <input type="email"
                                   wire:model="parsedUsers.{{ $index }}.email"
                                   class="border p-2 w-full"
                            />
                            @error("parsedUsers.$index.email")
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Import Button --}}
    <flux:button wire:click="import" variant="primary"
    >
        Import Users
    </flux:button>

    {{-- Success Message --}}
    @if(session()->has('success'))
        <p class="mt-2 text-green-500">{{ session('success') }}</p>
    @endif
</div>


