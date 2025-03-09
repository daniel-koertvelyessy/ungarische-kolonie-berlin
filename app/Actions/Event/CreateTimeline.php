<?php

namespace App\Actions\Event;

use App\Livewire\Forms\Event\EventTimelineForm;
use App\Models\EventTimeline;
use Illuminate\Support\Facades\DB;

class CreateTimeline
{
    /**
     * @throws \Throwable
     */
    public static function handle(EventTimelineForm $form): EventTimeline
    {
        return DB::transaction(function () use ($form) {
            return EventTimeline::create([
                'start' => $form->start,
                'duration' => $form->duration,
                'end' => $form->end,
                'event_id' => $form->event_id,
                'title' => $form->title,
                'description' => $form->description,
                'notes' => $form->notes,
                'member_id' => $form->member_id,
                'user_id' => $form->user_id,
                'place' => $form->place,
                'performer' => $form->performer,
                'title_extern' => $form->title_extern,
            ]);
        });
    }
}
