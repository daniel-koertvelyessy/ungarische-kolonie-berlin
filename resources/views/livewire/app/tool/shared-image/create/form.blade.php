<div class="space-y-4">

    @if (session('success'))
        <flux:callout variant="success" icon="check-circle">
            {{ session('success') }}
        </flux:callout>
    @endif

    <flux:card class="max-w-xl mx-auto p-4">
        <form wire:submit.prevent="save" class="space-y-4">
            <flux:input.file
                label="Bild hochladen"
                wire:model="form.image"
                hint="Maximal 10 MB, nur Bilder"
                accept="image/*"
                drag
            />

            @error('form.image')
            <flux:callout variant="warning" icon="exclamation-circle">{{ $message }}</flux:callout>
            @enderror

            @if ($form->image)
                <div class="mt-2">
                    Vorschau:
                    <img src="{{ $form->image->temporaryUrl() }}" class="w-48 rounded-xl shadow" />
                </div>
            @endif

            <flux:input
                label="Bildbeschreibung"
                wire:model.defer="form.label"
                placeholder="Kurze Beschreibung des Bildes"
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
