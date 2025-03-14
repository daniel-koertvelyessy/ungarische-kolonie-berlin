<?php

namespace App\Actions\Global;

use App\Livewire\Forms\Blog\PostForm;
use App\Livewire\Forms\Global\MailingListForm;
use App\Models\Blog\Post;
use App\Models\MailingList;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\isInstanceOf;

final class UpdateMailingListEntry extends Action
{
    public static function handle(MailingListForm $form, MailingList $list): MailingList
    {
        return DB::transaction(function () use ($form, $list) {

            $result = MailingList::query()->where('id', $list->id)->updateOrCreate([
                'email' => $form->email,
                'terms_accepted' => $form->terms_accepted,
                'update_on_events' => $form->update_on_events,
                'update_on_articles' => $form->update_on_articles,
                'update_on_notifications' => $form->update_on_notifications,
                'locale' => $form->locale,
            ]);

            if ( $result instanceof (MailingList::class) ){
                return $result;
            }

            return $list;

        });

    }
}
