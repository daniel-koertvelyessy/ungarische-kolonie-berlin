@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>{{ config('app.name') }} Events</title>
        <link>{{ url('/') }}</link>
        <description>Upcoming events from {{ config('app.name') }}</description>
        <language>{{ $locale }}</language>
        <lastBuildDate>{{ $lastBuildDate }}</lastBuildDate>
        <atom:link href="{{ route('events.feed') }}" rel="self" type="application/rss+xml" />

        @foreach ($events as $event)
            <item>
                <title>{{ htmlspecialchars($event->title[$locale] ?? 'Untitled Event', ENT_QUOTES, 'UTF-8') }}</title>
                <link>{{ route('events.show', ['slug' => $event->slug[$locale] ?? '#']) }}</link>
                <guid isPermaLink="true">{{ route('events.show', ['slug' => $event->slug[$locale] ?? '#']) }}</guid>
                <pubDate>{{ $event->event_date?->toRssString() ?? now()->toRssString() }}</pubDate>
                <description>
                    <![CDATA[
                    <p>{{ htmlspecialchars($event->excerpt[$locale] ?? 'No excerpt available', ENT_QUOTES, 'UTF-8') }}</p>
                    <p>{{ htmlspecialchars($event->description[$locale] ?? 'No description available', ENT_QUOTES, 'UTF-8') }}</p>
                    @if ($event->venue)
                        <p>
                            <strong>Venue:</strong> {{ htmlspecialchars($event->venue->name, ENT_QUOTES, 'UTF-8') }}<br>
                            <strong>Address:</strong> {{ htmlspecialchars($event->venue->address . ', ' . $event->venue->city, ENT_QUOTES, 'UTF-8') }}
                        </p>
                    @endif
                    <p><strong>Date:</strong> {{ $event->event_date?->toDateString() }}</p>
                    @if ($event->entry_fee)
                        <p><strong>Entry Fee:</strong> {{ $event->entry_fee }} HUF</p>
                    @endif
                    ]]>
                </description>
            </item>
        @endforeach
    </channel>
</rss>
