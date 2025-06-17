@props([
    'histories',
    'model' => 'event'
    ])
@if(Auth()->user()->isBoardMember())

    <section class="flex flex-col items-end w-full">
        <flux:heading>Historie</flux:heading>
        @foreach($histories as $entry)
            <flux:text size="sm">{{ $entry->action }} / {{ $entry->changed_at->diffForHumans() }} / {{ optional($entry->user)->email }}</flux:text>
            @if($entry->changes)
                <ul class="space-y-1">
                    @foreach ($entry->changes['old'] ?? [] as $key => $old)
                        @php
                            $new = $entry->changes['new'][$key] ?? null;
                            $label = $labels[$key] ?? $key;
                        @endphp
                        <li class="flex items-center gap-2">
                            <flux:text size="sm" variant="strong">{{ __($model.'.'.$key) }}:</flux:text>
                            <flux:text size="sm" class="text-red-600">{{ $old }}</flux:text>
                            →
                            <flux:text size="sm" class="text-green-600">{{ $new }}</flux:text>
                        </li>
                    @endforeach
                </ul>
            @endif
        @endforeach
    </section>
@endif
