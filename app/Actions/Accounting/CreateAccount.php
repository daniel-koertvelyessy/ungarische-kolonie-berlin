<?php

namespace App\Actions\Accounting;

use App\Models\Accounting\Account;
use Illuminate\Support\Facades\DB;

class CreateAccount
{
    public static function handle(array $data): Account
    {

        return DB::transaction(function () use ($data) {
            return Account::create([
                'name' => $data['name'],
                'number' => $data['number'],
                'institute' => $data['institute'],
                'type' => $data['type'],
                'iban' => $data['iban'],
                'bic' => $data['bic'],
                'starting_amount' => Account::makeCentInteger($data['starting_amount']),
            ]);
        });
    }
}
