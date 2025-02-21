<?php

namespace App\Livewire\Accounting\Account\Create;

use App\Actions\Accounting\UpdateAccount;
use App\Livewire\Forms\AccountForm;
use App\Models\Accounting\Account;
use Flux\Flux;
use Illuminate\Auth\Access\AuthorizationException;
use Livewire\Component;

class Form extends Component
{
    public AccountForm $form;

    public Account $account;

    public function mount(Account $account)
    {
        $this->form->set($account);
    }

    public function updatedAccount(Account $account)
    {
        $this->form->set($account);
    }

    public function updateAccountData(): void
    {
        $this->checkUser();
        UpdateAccount::handle($this->form);
        Flux::toast(
            heading: 'Erfolg',
            text: 'Das Konto  wurde aktualisiert',
            variant: 'success',
        );
    }

    protected function checkUser(): void
    {
        try {
            $this->authorize('update', $this->form);
        } catch (AuthorizationException $e) {
            Flux::toast(
                heading: 'Forbidden',
                text: 'You have no permission to edit this! '.$e->getMessage(),
                variant: 'danger',
            );

            return;
        }
    }

    public function render()
    {
        return view('livewire.accounting.account.create.form');
    }
}
