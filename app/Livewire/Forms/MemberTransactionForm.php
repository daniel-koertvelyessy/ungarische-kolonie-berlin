<?php

namespace App\Livewire\Forms;

use App\Actions\Accounting\CreateMemberTransaction;
use App\Models\Accounting\Account;
use App\Models\Event\Event;
use App\Models\Membership\Member;
use App\Models\Membership\MemberTransaction;
use Livewire\Component;

class MemberTransactionForm extends Component
{
    public $date;

    public $label;

    public $amount;

    public $member_id;

    public $transaction_id;

    public $event_id;

    public $events = [];

    public $amount_net;

    public int $vat = 19;

    public $tax;

    public $account_id;

    public $booking_account_id;

    public function mount(Member $member)
    {
        $this->member_id = $member->id;
        $this->date = now()->format('Y-m-d');
        $this->events = Event::select('id', 'title')
            ->get();
    }

    public function addTransaction()
    {
        $this->authorize('create', MemberTransaction::class);

        $this->validate();

        $amountInCents = Account::makeCentInteger($this->amount);

        $memberTransaction = CreateMemberTransaction::handle([
            'date' => $this->date,
            'label' => $this->label,
            'member_id' => $this->member_id,
            'event_id' => $this->event_id,
            'amount' => $amountInCents,
            'amount_net' => $amountInCents,
            'vat' => 0,
            'tax' => 0,
            'account_id' => $this->account_id,
            'booking_account_id' => $this->booking_account_id,
        ]);

        $this->dispatch('updated-payments');
    }

    protected function rules(): array
    {
        return [
            'account_id' => 'required',
            'date' => 'required',
            'label' => 'required',
            'amount' => 'required',
            'event_id' => ['nullable', 'exists:events,id'],
            'member_id' => 'exists:members,id',
        ];
    }
}
