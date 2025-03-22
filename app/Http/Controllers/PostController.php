<?php

namespace App\Http\Controllers;

use App\Enums\EventStatus;
use App\Models\Blog\Post;
use Flux\Flux;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PostController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        return view('posts.index', [
            'posts' => Post::query()
                ->where('posts.status', EventStatus::PUBLISHED->value)
                ->whereNotNull('published_at')
                ->get(),
            'locale' => app()->getLocale(),
        ]);
    }

    public function show(string $slug): \Illuminate\View\View
    {
        $locale = app()->getLocale();

        try {
            $post = Post::query()
                ->with('images')
                ->where("slug->{$locale}", $slug) // Match the slug for the specific locale
                ->firstOrFail();
            $images = $post->images;

            return view('posts.show', [
                'post' => $post,
                'images' => $images,
                'locale' => $locale,
            ]);

        } catch (ModelNotFoundException $e) {
            Flux::toast('Post not found!', 'Fehler');

            return view('posts.index');
        }

    }
}
