<?php

namespace App\Livewire\Forms;

use App\Actions\Event\CreateEventVisitor;
use App\Enums\Gender;
use App\Models\Event\EventVisitor;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class EventVisitorForm extends Form
{
    public EventVisitor $event_visitor;
    public $id;
    public $name;
    public $email;
    public $phone;
    public $event_id;
    public $gender;
    public $transaction_id;
    public $member_id;
    public $event_subscription_id;


    public function set(EventVisitor $visitor): void
    {
        $this->id = $visitor->id;
        $this->name = $visitor->name;
        $this->email = $visitor->email;
        $this->phone = $visitor->phone;
        $this->event_id = $visitor->event_id;
        $this->gender = $visitor->gender;
        $this->transaction_id = $visitor->transaction_id;
        $this->member_id = $visitor->member_id;
        $this->event_subscription_id = $visitor->event_subscription_id;
    }

    public function create(): EventVisitor
    {

        $this->validate();
        return CreateEventVisitor::handle($this);
    }

    protected function rules(): array
    {
        return [
            'name'                  => 'required',
            'email'                 => 'nullable|email',
            'event_id'              => 'nullable|exists:events,id',
            'gender'                => [Rule::enum(Gender::class)],
            'transaction_id'        => 'nullable|exists:transactions,id',
            'member_id'             => 'nullable|exists:members,id',
            'event_subscription_id' => 'nullable|exists:event_subscriptions,id',
            'phone'                 => 'nullable'
        ];
    }

}
