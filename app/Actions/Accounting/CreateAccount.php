<?php

namespace App\Actions\Accounting;

use App\Models\Accounting\Account;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CreateAccount
{
    public static function create(array $data): Account
    {
        Validator::make($data, [
            'name'      => ['required', 'string', Rule::unique('accounts', 'name')],
            'number'    => ['required', 'string', Rule::unique('accounts', 'number')],
            'institute' => 'string|nullable',
            'iban'      => 'string|nullable',
            'bic'       => 'string|nullable',

        ])
            ->validate();

        return DB::transaction(function () use ($data)
        {
            return Account::create([
                'name'      => $data['name'],
                'number'    => $data['number'],
                'institute' => $data['institute'],
                'iban'      => $data['iban'],
                'bic'       => $data['bic'],
            ]);
        });
    }
}
