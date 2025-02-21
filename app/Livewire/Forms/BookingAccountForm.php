<?php

namespace App\Livewire\Forms;

use App\Actions\Accounting\CreateBookingAccount;
use App\Enums\BookingAccountType;
use Flux\Flux;
use Illuminate\Validation\Rule;
use Livewire\Form;

class BookingAccountForm extends Form
{
    public $id;

    public $type;

    public $number;

    public $label;

    public function create()
    {
        $this->validate();

        $booking_account = CreateBookingAccount::create([
            'type' => $this->type,
            'number' => $this->number,
            'label' => $this->label,
        ]);

        if ($booking_account) {
            Flux::toast(
                heading: 'Erfolg',
                text: 'Das Buchungskonto wurde erstellt',
                variant: 'success',
            );
            $this->id = $booking_account->id;
        }

        Flux::modal('add-account-modal')
            ->close();
    }

    protected function rules(): array
    {
        return [
            'type' => ['required', Rule::enum(BookingAccountType::class)],
            'number' => ['required', 'string', Rule::unique('booking_accounts', 'number')],
            'label' => ['required', 'string'],
        ];
    }
}
