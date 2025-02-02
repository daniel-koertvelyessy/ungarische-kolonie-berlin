<?php

namespace App\Actions\Accounting;

use App\Models\Accounting\Account;
use App\Models\Accounting\BookingAccount;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CreateBookingAccount
{
    public static function create(array $data): BookingAccount
    {
        Validator::make($data, [
            'type'   => ['required', 'string'],
            'number' => ['required', 'string', Rule::unique('booking_accounts', 'number')],
            'label'  => ['required','string'],
        ])->validate();

        return DB::transaction(function () use ($data)
        {
            return BookingAccount::create([
                'type'   => $data['type'],
                'number' => $data['number'],
                'label'  => $data['label'],
            ]);
        });
    }
}
