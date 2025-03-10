<a href="{{ route('post.show',$post->slug[app()->getLocale()]) }}" role="listitem" aria-label="{{ $post->title[app()->getLocale()] }}">
<flux:card class="space-y-3 my-3 hover:bg-teal-50 dark:hover:bg-emerald-800 transition duration-500 ">

    <flux:heading size="lg">{{ $post->title[app()->getLocale()] }}</flux:heading>



</flux:card>
</a>
