@props([
    'histories',
    'model' => 'event'
])

@if (Auth()->user()->isBoardMember())
    @php
        $labels = [
            'amount_gross' => 'Bruttobetrag',
            'vat' => 'MwSt.',
            'tax' => 'Steuer',
            'type' => 'Buchungstyp',
            'title' => 'Titel',
            'slug' => 'Slug',
            'excerpt' => 'Kurzbeschreibung',
            'description' => 'Beschreibung',
        ];
    @endphp

    <aside class="mt-8">
        <flux:accordion>
            <flux:accordion.item>
                <flux:accordion.heading>Historie</flux:accordion.heading>
                <flux:accordion.content class="divide-y space-y-1">
                    @foreach($histories as $entry)
                        <section>
                            <flux:text size="sm"
                                       variant="strong"
                            >{{ $entry->action }} / {{ $entry->changed_at->diffForHumans() }} / {{ optional($entry->user)->email }}</flux:text>
                            @if($entry->changes)
                                <ul class="space-y-1">
                                    @foreach ($entry->changes['old'] ?? [] as $key => $old)
                                        @php
                                            $new = $entry->changes['new'][$key] ?? null;
                                            $label = $labels[$key] ?? $key;
                                            $oldParsed = \App\Helpers\FormatHelper::tryParseJson($old);
                                            $newParsed = \App\Helpers\FormatHelper::tryParseJson($new);
                                        @endphp

                                        @if (is_array($oldParsed) && is_array($newParsed))
                                            @foreach ($oldParsed as $locale => $oldVal)
                                                @php
                                                    $newVal = $newParsed[$locale] ?? null;
                                                @endphp
                                                <li class="flex items-center gap-1">
                                                    <span class="text-xs ">{{ $label }} ({{ strtoupper($locale) }}):</span>
                                                    <span class="text-red-600 text-xs">{{ \App\Helpers\FormatHelper::formatValueHistory($key, $oldVal) }}</span>
                                                    →
                                                    <span class="text-green-600 text-xs">{{ \App\Helpers\FormatHelper::formatValueHistory($key, $newVal) }}</span>
                                                </li>
                                            @endforeach
                                        @else
                                            <li class="flex items-center gap-1">
                                                <span class="text-xs">{{ $label }}:</span>
                                                <span class="text-red-600 text-xs">{{ \App\Helpers\FormatHelper::formatValueHistory($key, $oldParsed) }}</span>
                                                →
                                                <span class="text-green-600 text-xs">{{ \App\Helpers\FormatHelper::formatValueHistory($key, $newParsed) }}</span>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </section>
                    @endforeach
                </flux:accordion.content>
            </flux:accordion.item>
        </flux:accordion>
    </aside>
@endif
