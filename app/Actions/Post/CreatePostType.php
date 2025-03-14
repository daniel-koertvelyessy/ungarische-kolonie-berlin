<?php

namespace App\Actions\Post;

use App\Livewire\Forms\Blog\PostTypeForm;
use App\Models\Blog\PostType;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\DB;

final class CreatePostType extends Action
{
    public static function handle(PostTypeForm $form, array $images = []): PostType
    {
        return DB::transaction(function () use ($form) {
            return PostType::create([
                'name' => $form->name,
                'slug' => $form->slug,
                'color' => $form->color,
                'description' => $form->description,
            ]);

        });

    }
}
