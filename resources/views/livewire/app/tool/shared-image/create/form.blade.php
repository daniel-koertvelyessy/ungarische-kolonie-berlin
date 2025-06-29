<div class="space-y-4">

    @if (session('success'))
        <flux:callout variant="success" icon="check-circle">
            {{ session('success') }}
        </flux:callout>
    @endif

        <flux:card class="max-w-xl mx-auto p-4">
            <form wire:submit.prevent="save" class="space-y-4">
                <flux:input.file
                    label="Bilder hochladen"
                    wire:model="form.images"
                    hint="Maximal 10 MB pro Bild, nur Bilder"
                    accept="image/*"
                    drag
                    multiple
                />

                @error('form.images.*')
                <flux:callout variant="warning" icon="exclamation-circle">{{ $message }}</flux:callout>
                @enderror

                @if (!empty($form->images))
                    <div class="mt-2">
                        <p>Vorschau:</p>
                        <div class="grid grid-cols-3 gap-4">
                            @foreach($form->images as $image)
                                <img src="{{ $image->temporaryUrl() }}" class="w-48 rounded-xl shadow" alt="Preview" />
                            @endforeach
                        </div>
                    </div>
                @endif

                <flux:textarea
                    rows="auto"
                    label="Bildbeschreibung"
                    wire:model.defer="form.label"
                    placeholder="Kurze Beschreibung für alle Bilder"
                    required
                />

                @error('form.label')
                <flux:callout variant="warning" icon="exclamation-circle">{{ $message }}</flux:callout>
                @enderror

                <flux:button type="submit" variant="primary">
                    Speichern
                </flux:button>
            </form>
        </flux:card>
</div>
