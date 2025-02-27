<div>

    <section class="flex items-center flex-col h-full w-full rounded-lg border-2 border-dashed border-gray-300 p-12 hover:border-gray-400 focus:outline-hidden focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
        <div>
            <flux:input type="file" wire:model="image" accept="image/*"/>
        </div>
    </section>
    <!-- Image Upload Form -->


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
