<?php

namespace App\Livewire\Forms;

use App\Actions\Accounting\CreateAccount;
use App\Enums\AccountType;
use App\Models\Accounting\Account;
use Flux\Flux;
use Illuminate\Validation\Rule;
use Livewire\Form;

class AccountForm extends Form
{
    public $id;
    public $name;
    public $number;
    public $institute;
    public $type;
    public $iban;
    public $bic;
    public $starting_amount;

    public function create(): void
    {
        $this->validate();
        $account = CreateAccount::create([
            'name'            => $this->name,
            'number'          => $this->number,
            'institute'       => $this->institute,
            'type'            => $this->type,
            'iban'            => $this->iban,
            'bic'             => $this->bic,
            'starting_amount' => Account::makeCentInteger($this->starting_amount),
        ]);


        if ($account) {
            Flux::toast(
                heading: 'Erfolg',
                text: 'Das Zahlungskonto wurde erstellt',
                variant: 'success',
            );
            $this->id = $account->id;
        }

        Flux::modal('add-account-modal')
            ->close();
    }

    protected function rules():array
    {
        return [
            'name'            => ['required', 'string', Rule::unique('accounts', 'name')],
            'number'          => ['required', 'string', Rule::unique('accounts', 'number')],
            'type'            => ['required', Rule::enum(AccountType::class)],
            'institute'       => 'string|nullable',
            'iban'            => 'string|nullable',
            'bic'             => 'string|nullable',
            'starting_amount' => 'required',
        ];
    }
}
