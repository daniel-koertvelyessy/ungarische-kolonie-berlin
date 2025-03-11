<?php

namespace App\Actions\Post;

use App\Livewire\Forms\Blog\PostForm;
use App\Models\Blog\Post;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\DB;

final class UpdatePost extends Action
{
    public static function handle(Postform $form): Post
    {
        return DB::transaction(function () use ($form) {
            Post::query()->findOrFail($form->id)->update([
                'title' => $form->title,
                'slug' => $form->slug,
                'body' => $form->body,
                'user_id' => $form->user_id,
                'status' => $form->status,
                'label' => $form->label,
                '$this->post_type_id' => $form->post_type_id,
            ]);

            return Post::query()->findOrFail($form->id);
        });

    }
}
