<?php

namespace App\Actions\Global;

use App\Livewire\Forms\Global\MailingListForm;
use App\Models\MailingList;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\DB;

final class UpdateMailingListEntry extends Action
{
    public static function handle(MailingListForm $form, MailingList $list): MailingList
    {
        return DB::transaction(function () use ($form, $list) {

            MailingList::query()->where('id', $list->id)->update([
                'email' => $form->email,
                'terms_accepted' => $form->terms_accepted,
                'update_on_events' => $form->update_on_events,
                'update_on_articles' => $form->update_on_articles,
                'update_on_notifications' => $form->update_on_notifications,
                'locale' => $form->locale,
            ]);

            return $list;

        });

    }
}
