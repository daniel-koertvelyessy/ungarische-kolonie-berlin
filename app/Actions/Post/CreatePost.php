<?php

namespace App\Actions\Post;

use App\Livewire\Forms\Blog\PostForm;
use App\Models\Blog\Post;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class CreatePost extends Action
{
    public static function handle(Postform $form, array $images = []): Post
    {
        return DB::transaction(function () use ($form) {

            Log::debug('post_type_id . '.$form->post_type_id);

            $post = Post::create([
                'title' => $form->title,
                'slug' => $form->slug,
                'body' => $form->body,
                'user_id' => $form->user_id,
                'status' => $form->status->value,
                'label' => $form->label,
                'post_type_id' => $form->post_type_id,
                'published_at' => $form->published_at,
                'event_id' => $form->event_id,
            ]);

            return $post;
        });

    }
}
