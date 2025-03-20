<?php

namespace App\Http\Controllers;

use Flux\Flux;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', [
            'posts'  => \App\Models\Blog\Post::query()
                ->where('posts.status', \App\Enums\EventStatus::PUBLISHED->value)
                ->whereNotNull('published_at')
                ->get(),
            'locale' => app()->getLocale(),
        ]);
    }

    public function show(string $slug)
    {
        $locale = app()->getLocale();

        try {
            $post = \App\Models\Blog\Post::query()
                ->with('images')
                ->where("slug->{$locale}", $slug) // Match the slug for the specific locale
                ->firstOrFail();
            $images = $post->images;

            return view('posts.show', [
                'post'   => $post,
                'images' => $images,
                'locale' => $locale,
            ]);

        } catch (ModelNotFoundException $e) {
            Flux::toast('Post not found!', 'Fehler');
            return view('posts.index');
        }

    }
}
