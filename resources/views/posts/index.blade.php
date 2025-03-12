<x-guest-layout title="{{ __('post.index.page.title') }}">
    <flux:heading size="xl">
        <h1>{{ __('post.index.page.title') }}</h1>
    </flux:heading>

    <div class="mx-auto mt-10 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 pt-10 sm:mt-16 sm:pt-16 lg:mx-0 lg:max-w-none lg:grid-cols-3">
        @forelse($posts as $post)

        <flux:card>
            <article class="flex max-w-xl flex-col items-start justify-between">
                <div class="flex items-center gap-x-4 text-xs">
                    <time datetime="2020-03-16" class="text-gray-500">{{ $post->published_at->locale($locale)->isoFormat('LLLL') }}</time>
                    <span class="relative z-10 rounded-full bg-{{ $post->type->color }}-200 px-3 py-1.5 font-medium text-gray-600 hover:bg-gray-100">{{ $post->type->name[$locale] }}</span>
                </div>
                <div class="group relative">
                    <h3 class="mt-3 text-lg/6 font-semibold text-emerald-600 group-hover:text-gray-600">
                        <a href="{{ route('posts.show',$post->slug[$locale]) }}" class="group-hover:underline">
                            <span class="absolute inset-0"></span>
                            <span class="prose dark:prose-invert">{{ $post->title[$locale] }}</span>
                        </a>
                    </h3>
                    <p class="mt-5 line-clamp-3 text-sm/6 text-gray-600 prose dark:prose-invert">{!!  $post->excerpt(150) !!}</p>
                </div>
                {{--
                <div class="relative mt-8 flex items-center gap-x-4">
                    <img src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="size-10 rounded-full bg-gray-50">
                    <div class="text-sm/6">
                        <p class="font-semibold text-gray-900">
                            <a href="#">
                                <span class="absolute inset-0"></span>
                                Michael Foster
                            </a>
                        </p>
                        <p class="text-gray-600">Co-Founder / CTO</p>
                    </div>
                </div>
                --}}
            </article>
        </flux:card>

    @empty

    @endforelse

    </div>

</x-guest-layout>
