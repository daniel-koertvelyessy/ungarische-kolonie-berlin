<?php

namespace App\Livewire\Forms;

use App\Actions\Accounting\CreateBooking;
use App\Actions\Accounting\CreateTransaction;
use App\Actions\Accounting\UpdateTransaction;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Models\Accounting\Account;
use App\Models\Accounting\Transaction;
use Flux\Flux;
use Illuminate\Validation\Rule;
use Livewire\Form;

class TransactionForm extends Form
{
    public $id;
    public $label;
    public $date;
    public $amount_net;
    public $vat;
    public $tax;
    public $amount_gross;
    public $account_id;
    public $receipt_id;
    public $booking_account_id;
    public $type;
    public $status = TransactionStatus::submitted->value;


    public function set(Transaction $transaction): void
    {
        $this->id = $transaction->id;
        $this->label = $transaction->label;
        $this->date = $transaction->date->format('Y-m-d');
        $this->amount_net = $transaction->netForHumans();
        $this->vat = ($transaction->vat);
        $this->tax = $transaction->taxForHumans();
        $this->amount_gross = $transaction->grossForHumans();
        $this->account_id = $transaction->account_id;
        $this->receipt_id = $transaction->receipt_id;
        $this->booking_account_id = $transaction->booking_account_id;
        $this->type = $transaction->type;
        $this->status = $transaction->status;
    }

    public function book()
    {
        $this->validate([
            'booking_account_id' => 'required|exists:booking_accounts,id',
            'status' => Rule::enum(TransactionStatus::class)
        ]);

        return CreateBooking::handle([
            'id'                 => $this->id,
            'booking_account_id' => $this->booking_account_id,
            'status'             => $this->status,
        ]);
    }

    public function create(): Transaction
    {
        $this->validate();

        return CreateTransaction::handle([
            'label'              => $this->label,
            'date'               => $this->date,
            'amount_net'         => Account::makeCentInteger($this->amount_net),
            'vat'                => Account::makeCentInteger($this->vat),
            'tax'                => $this->tax,
            'amount_gross'       => Account::makeCentInteger($this->amount_gross),
            'account_id'         => $this->account_id,
            'receipt_id'         => $this->receipt_id,
            'booking_account_id' => $this->booking_account_id,
            'type'               => $this->type,
            'status'             => $this->status,
        ]);
    }

    public function update(): Transaction
    {
        $this->validate();

        return UpdateTransaction::handle([
            'id'                 => $this->id,
            'label'              => $this->label,
            'date'               => $this->date,
            'amount_net'         => Account::makeCentInteger($this->amount_net),
            'vat'                => Account::makeCentInteger($this->vat),
            'tax'                => $this->tax,
            'amount_gross'       => Account::makeCentInteger($this->amount_gross),
            'account_id'         => $this->account_id,
            'receipt_id'         => $this->receipt_id,
            'booking_account_id' => $this->booking_account_id,
            'type'               => $this->type,
            'status'             => $this->status,
        ]);
    }

    protected function rules(): array
    {
        return [
            'id'                 => ['nullable','integer'],
            'label'              => ['string', 'required_unless:id,null'],
            'amount_net'         => ['required_unless:id,null'],
            'date'               => ['required_unless:id,null', 'date'],
            'vat'                => ['required_unless:id,null', 'integer'],
            'tax'                => ['nullable',],
            'amount_gross'       => ['required_unless:id,null',],
            'account_id'         => ['required_unless:id,null', 'integer'],
            'receipt_id'         => ['nullable'],
            'booking_account_id' => ['nullable', 'integer'],
            'type'               => ['required_unless:id,null', Rule::enum(TransactionType::class)],
            'status'             => ['required_unless:id,null', Rule::enum(TransactionStatus::class)],
        ];
    }

    protected function messages()
    {
        return [
            'label.required'        => 'Bitte den Buchungstext eingeben.',
            'amount_net.required'   => 'Der Nettopreis fehlt.',
            'vat.required'          => 'Die % MWst Angabe fehlt',
            'amount_gross.required' => 'Der Bruttobetrag muss angegeben werden.',
            'account_id.required'   => 'Bitte ein Zahlungskonto angeben',
            'receipt_id.required'   => 'Es wurde noch kein Beleg angefügt!',
            'type.required'         => 'Der Typ der Buchung muss angegeben werden',
            'status.required'       => 'Der Buchungsstatus muss angegeben werden',
        ];
    }

}
