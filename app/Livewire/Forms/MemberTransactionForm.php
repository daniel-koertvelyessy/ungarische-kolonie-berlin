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
    public TransactionForm $form;

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

    public function mount(Member $member): void
    {
        $this->member_id = $member->id;
        $this->date = now()->format('Y-m-d');
        $this->events = Event::select('id', 'title')
            ->get();
    }

    public function addTransaction(): void
    {
        $this->authorize('create', MemberTransaction::class);

        $this->validate();

        $amountInCents = Account::makeCentInteger($this->amount);

        $memberTransaction = CreateMemberTransaction::handle($this->form, Member::find($this->member_id)
        );

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
