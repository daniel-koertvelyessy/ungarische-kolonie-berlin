<div>
    <!-- Image Upload Form -->
    <flux:input type="file" wire:model="image" label="Logo" accept="image/*"/>

    @if ($image)
        <div wire:loading wire:target="image">Uploading...</div>
    @endif

    <!-- Display Thumbnail if Available -->
    @if ($thumbnail)
        <div>
            <h3>Thumbnail:</h3>
            <img src="{{ $thumbnail }}" alt="Image Thumbnail" width="150" height="150" />
        </div>
    @endif
</div>
