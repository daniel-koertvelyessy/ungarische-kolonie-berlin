<?php

namespace App\Actions\Event;

use App\Livewire\Forms\EventVisitorForm;
use App\Models\Event\EventVisitor;
use Illuminate\Support\Facades\DB;

class CreateEventVisitor
{
    public static function handle(EventVisitorForm $visitor): EventVisitor
    {
        return DB::transaction(function () use ($visitor) {
            return EventVisitor::create([
                'name' => $visitor->name,
                'email' => $visitor->email,
                'phone' => $visitor->phone,
                'event_id' => $visitor->event_id,
                'gender' => $visitor->gender,
                'transaction_id' => $visitor->transaction_id,
                'member_id' => $visitor->member_id,
                'event_subscription_id' => $visitor->event_subscription_id,

            ]);
        });
    }
}
