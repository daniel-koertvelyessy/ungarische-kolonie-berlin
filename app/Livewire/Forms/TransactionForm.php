<?php

namespace App\Livewire\Forms;

use App\Actions\Accounting\CreateTransaction;
use App\Enums\AccountType;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Models\Accounting\Account;
use App\Models\Accounting\Receipt;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class TransactionForm extends Form
{
    public $label;
    public $amount_net;
    public $vat;
    public $tax;
    public $amount_gross;
    public $account_id;
    public $receipt_id;
    public $booking_account_id;
    public $type;
    public $status = TransactionStatus::submitted->value;

    public function create()
    {
        $this->validate();

        return CreateTransaction::create([
            'label'              => $this->label,
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
            'label'              => ['required', 'string'],
            'amount_net'         => ['required'],
            'vat'                => ['required', 'integer'],
            'tax'                => ['nullable',],
            'amount_gross'       => ['required',],
            'account_id'         => ['required', 'integer'],
            'receipt_id'         => ['nullable'],
            'booking_account_id' => ['nullable', 'integer'],
            'type'               => ['required', Rule::enum(TransactionType::class)],
            'status'             => ['required', Rule::enum(TransactionStatus::class)],
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
