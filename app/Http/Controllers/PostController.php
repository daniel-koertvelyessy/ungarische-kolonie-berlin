<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\EventStatus;
use App\Enums\Locale;
use App\Models\Blog\Post;
use Flux\Flux;
use Illuminate\View\View;

final class PostController extends Controller
{
    public function index(): View
    {
        return view('posts.index', [
            'posts' => Post::query()
                ->where('posts.status', EventStatus::PUBLISHED->value)
                ->whereNotNull('published_at')
                ->get(),
            'locale' => app()->getLocale(),
        ]);
    }

    public function show(string $slug): View
    {

        $post_de = Post::query()->with('images')->whereJsonContains('slug->de', $slug)->first();
        $post_hu = Post::query()->with('images')->whereJsonContains('slug->hu', $slug)->first();

        if ($post_de) {
            $post = $post_de;
            $images = $post->images;

            return view('posts.show', [
                'post' => $post,
                'images' => $images,
                'locale' => Locale::DE->value,
            ]);

        }

        if ($post_hu) {
            $post = $post_hu;
            $images = $post->images;

            return view('posts.show', [
                'post' => $post,
                'images' => $images,
                'locale' => Locale::HU->value,
            ]);

        }

        Flux::toast('Post not found!', 'Fehler');

        return view('posts.index');

    }
}
