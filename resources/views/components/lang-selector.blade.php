<x-dropdown >
    <x-slot name="trigger">
        <div class="block px-4 py-2 text-xs text-gray-400">
            {{ __('app.locale') }}
        </div>
    </x-slot>
    <x-slot name="content">
@foreach (\App\Enums\Locale::toArray() as $locale)
    <x-dropdown-link href="{{url('/lang/'.$locale)}}">
        {{ strtoupper($locale) }}
    </x-dropdown-link>
@endforeach
    </x-slot>
</x-dropdown>
