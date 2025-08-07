<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Accounting;

use App\Actions\Accounting\CreateBookingAccount;
use App\Enums\BookingAccountType;
use Flux\Flux;
use Illuminate\Validation\Rule;
use Livewire\Form;

final class BookingAccountForm extends Form
{
    public $id;

    public $type;

    public $number;

    public $label;

    public function create(): void
    {
        $this->validate();

        $booking_account = CreateBookingAccount::create([
            'type' => $this->type,
            'number' => $this->number,
            'label' => $this->label,
        ]);

        Flux::toast(
            text: 'Das Buchungskonto wurde erstellt',
            heading: 'Erfolg',
            variant: 'success',
        );
        $this->id = $booking_account->id;

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
