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
                <title>{!! $event->title[$locale] ?? 'Untitled Event' !!}</title>
                <link>{{ route('events.show', ['slug' => $event->slug[$locale] ?? '#']) }}</link>
                <guid isPermaLink="true">{{ route('events.show', ['slug' => $event->slug[$locale] ?? '#']) }}</guid>
                <pubDate>{{ $event->event_date?->toRssString() ?? now()->toRssString() }}</pubDate>
                <description>
                    <![CDATA[
                    <p>{!! $event->excerpt[$locale] ?? 'No excerpt available' !!}</p>
                    <p>{!! $event->description[$locale] ?? 'No description available' !!}</p>
                    @if ($event->venue)
                        <p>
                            <strong>Venue:</strong> {{ $event->venue->name }}<br>
                            <strong>Address:</strong> {{ $event->venue->address . ', ' . $event->venue->city }}
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
