<?php

namespace App\Actions\Post;

use App\Livewire\Forms\Blog\PostTypeForm;
use App\Models\Blog\PostType;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\DB;

final class UpdatePostType extends Action
{
    public static function handle(PostTypeForm $form): PostType
    {
        return DB::transaction(function () use ($form) {
            PostType::query()->findOrFail($form->id)->update([
                'name' => $form->name,
                'slug' => $form->slug,
                'color' => $form->color,
                'description' => $form->description,
            ]);

            return PostType::query()->findOrFail($form->id);

        });

    }
}
