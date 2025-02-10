<?php

namespace App\Livewire\Event\Show;

use App\Actions\Accounting\CreateEventPayment;
use App\Enums\TransactionType;
use App\Livewire\Forms\EventForm;
use App\Livewire\Forms\TransactionForm;
use App\Models\Accounting\Transaction;
use App\Models\Event;
use Livewire\Attributes\Computed;
use Livewire\Component;

class EventPayment extends Component
{

    public EventForm $eventForm;
    public TransactionForm $transactionForm;
    public $member_id = 'extern';

    public bool $setEntryFee = false;


    #[Computed]
    public function members()
    {
        return \App\Models\Membership\Member::select('id', 'name')
            ->where('left_at', null)
            ->get();
    }

    #[Computed]
    public function accounts()
    {
        return \App\Models\Accounting\Account::select('id', 'name')->get();
    }

    #[Computed]
    public function booking_accounts()
    {
        return \App\Models\Accounting\BookingAccount::select('id', 'label', 'nummer')->get();
    }

    public function mount(Event $event)
    {
        $this->eventForm->setEvent($event);
        $this->transactionForm->type = TransactionType::Deposit->value;
        $this->transactionForm->amount_gross = number_format($this->eventForm->entry_fee, 2, ',', '.');
        $this->transactionForm->label = 'Zahlung Abendkasse';
    }

    public function updatedSetEntryFee()
    {
        $this->transactionForm->amount_gross = $this->setEntryFee
            ? number_format($this->eventForm->entry_fee_discounted, 2, ',', '.')
            : number_format($this->eventForm->entry_fee, 2, ',', '.');
    }

    public function storePayment()
    {
        CreateEventPayment::handle([
            'event' => $this->eventForm,
            'transaction' => $this->transactionForm,
            'member_id' => $this->member_id,
        ]);

    }

    public function addEventPayment() {}

    public function render()
    {
        return view('livewire.event.show.event-payment-form');
    }
}
