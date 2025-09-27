<?php

declare(strict_types=1);

namespace App\Actions\Event;

use App\Actions\Accounting\CreateTransaction;
use App\Livewire\Forms\Accounting\TransactionForm;
use App\Livewire\Forms\Event\EventVisitorForm;
use App\Models\Event\Event;
use App\Models\Event\EventTransaction;
use App\Models\Event\EventVisitor;
use Illuminate\Support\Facades\DB;

final class CreateBoxOfficeEntry
{
    public static function handle(TransactionForm $form, Event $event, EventVisitorForm $visitor): EventVisitor
    {
        return DB::transaction(function () use ($visitor, $form, $event) {
            $transaction = CreateTransaction::handle($form);

            EventTransaction::create([
                'transaction_id' => $transaction->id,
                'event_id' => $event->id,
            ]);

            return EventVisitor::create([
                'name' => 'Karte Abendkasse',
                'email' => $visitor->email,
                'phone' => $visitor->phone,
                'event_id' => $event->id,
                'gender' => $visitor->gender,
                'transaction_id' => $transaction->id,
                'member_id' => $visitor->member_id,
                'event_subscription_id' => $visitor->event_subscription_id,
            ]);
        });
    }
}
