<a href="{{ route('posts.show',$post->slug[app()->getLocale()]) }}" role="listitem" aria-label="{{ $post->title[app()->getLocale()] }}">
<flux:card class="space-y-3 my-3 hover:bg-teal-50 dark:hover:bg-emerald-800 transition duration-500 ">

    <flux:heading size="lg">{{ $post->title[app()->getLocale()] }}</flux:heading>
    <flux:text>{!! \Illuminate\Support\Str::limit($post->body[app()->getLocale()],150,'...',true) !!}</flux:text>

@if($post->published_at)
    <flux:text size="sm">{{ $post->published_at->diffForHumans()     }}</flux:text>
@endif
    <flux:badge color="{{ $post->typeColor() }}" size="sm">{{ $post->type->name[app()->getLocale()] }}</flux:badge>
    <flux:text size="sm">aktualisiert: {{ $post->updated_at->diffForHumans()     }}</flux:text>
</flux:card>
</a>
