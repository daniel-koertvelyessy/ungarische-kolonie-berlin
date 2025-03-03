<?php

namespace App\Actions\Accounting;

use App\Models\Accounting\BookingAccount;
use Illuminate\Support\Facades\DB;

final class CreateBookingAccount
{
    public static function create(array $data): BookingAccount
    {

        return DB::transaction(function () use ($data) {
            return BookingAccount::create([
                'type' => $data['type'],
                'number' => $data['number'],
                'label' => $data['label'],
            ]);
        });
    }
}
