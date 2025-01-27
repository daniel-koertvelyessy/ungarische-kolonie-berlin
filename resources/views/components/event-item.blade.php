<a href="{{ route('events.show',$event->slug[app()->getLocale()]) }}" role="listitem" aria-label="{{ $event->title[app()->getLocale()] }}">
<flux:card class="space-y-3 my-3 hover:bg-teal-50 dark:hover:bg-emerald-800 transition duration-500 {{ $event->starts_at < now() ? 'border-zinc-600' : 'border-emerald-600' }}">

    <flux:heading size="lg">{{ $event->title[app()->getLocale()] }}</flux:heading>

    <flux:text size="sm">{{ __('event.begins') }}: {{ $event->starts_at }} | {{ __('event.ends') }}: {{ $event->ends_at }} | {{ __('event.venue') }}: {{ $event->venue->name }} </flux:text>

</flux:card>
</a>
