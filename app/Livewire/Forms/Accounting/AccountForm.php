<?php

namespace App\Livewire\Forms\Accounting;

use App\Actions\Accounting\CreateAccount;
use App\Enums\AccountType;
use App\Models\Accounting\Account;
use Flux\Flux;
use Illuminate\Validation\Rule;
use Livewire\Form;

class AccountForm extends Form
{
    public Account $account;

    public $id;

    public $name;

    public $number;

    public $institute;

    public $type;

    public $iban;

    public $bic;

    public $starting_amount;

    public function set(Account $account): void
    {
        $this->name = $account->name;
        $this->number = $account->number;
        $this->institute = $account->institute;
        $this->type = $account->type;
        $this->iban = $account->iban;
        $this->bic = $account->bic;
        $this->starting_amount = number_format(($account->starting_amount / 100), 2, ',', '.');
        $this->id = $account->id;
    }

    public function create(): void
    {
        $this->validate();
        $account = CreateAccount::handle([
            'name' => $this->name,
            'number' => $this->number,
            'institute' => $this->institute,
            'type' => $this->type,
            'iban' => $this->iban,
            'bic' => $this->bic,
            'starting_amount' => Account::makeCentInteger($this->starting_amount),
        ]);

        Flux::toast(
            text: 'Das Zahlungskonto wurde erstellt',
            heading: 'Erfolg',
            variant: 'success',
        );
        $this->id = $account->id;

        Flux::modal('add-account-modal')
            ->close();
    }

    public function update(): void
    {

        $this->validate();
        $account = '';

    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', Rule::unique('accounts', 'name')],
            'number' => ['required', 'string', Rule::unique('accounts', 'number')],
            'type' => ['required', Rule::enum(AccountType::class)],
            'institute' => 'string|nullable',
            'iban' => 'string|nullable',
            'bic' => 'string|nullable',
            'starting_amount' => 'required',
        ];
    }
}
