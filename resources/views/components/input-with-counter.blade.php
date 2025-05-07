<div x-data="{ maxLength: {{ $maxLength }} }">

    <flux:input
        wire:model="{{ $model }}"
        label="{{ $label??'' }}"
        size="{{ $size }}"
        x-bind:maxlength="maxLength"
    />
    <flux:text
        class="ml-2"
        size="sm"
        x-text="`${maxLength - ($wire.{{ $model }} || '').length}/${maxLength}`"
        x-bind:class="{
            'text-emerald-600': (maxLength - ($wire.{{ $model }} || '').length) > 50,
            'text-yellow-500': (maxLength - ($wire.{{ $model }} || '').length) <= 50 && (maxLength - ($wire.{{ $model }} || '').length) > 0,
            'text-red-500': (maxLength - ($wire.{{ $model }} || '').length) <= 0
        }"
    ></flux:text>
</div>
