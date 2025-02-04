<?php

namespace App\Actions\Accounting;

use App\Enums\AccountType;
use App\Models\Accounting\Account;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CreateAccount
{
    public static function create(array $data): Account
    {



        return DB::transaction(function () use ($data)
        {
            return Account::create([
                'name'            => $data['name'],
                'number'          => $data['number'],
                'institute'       => $data['institute'],
                'type'            => $data['type'],
                'iban'            => $data['iban'],
                'bic'             => $data['bic'],
                'starting_amount' => Account::makeCentInteger($data['starting_amount']),
            ]);
        });
    }

}
