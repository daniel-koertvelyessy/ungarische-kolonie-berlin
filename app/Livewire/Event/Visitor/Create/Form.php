<?php

namespace App\Livewire\Event\Visitor\Create;

use App\Livewire\Forms\Event\EventVisitorForm;
use App\Models\Event\Event;
use App\Models\Event\EventSubscription;
use App\Models\Membership\Member;
use Flux\Flux;
use Livewire\Component;

class Form extends Component
{
    public EventVisitorForm $form;

    public $members = [];

    public $subscribers = [];

    public function mount(Event $event): void
    {
        $this->form->event_id = $event->id;
        $this->members = Member::select('id', 'name', 'first_name')->get();
        $this->subscribers = EventSubscription::select()->get();

    }

    public function add()
    {
        try {
            $this->authorize('create', Event::class);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            Flux::toast(
                text: 'You have no permission to edit this event! '.$e->getMessage(),
                heading: 'Forbidden',
                variant: 'danger',
            );

            return;
        }

        $this->form->create();
        Flux::toast(__('event.visitor-modal.toast.msg'), __('event.visitor-modal.toast.heading'), variant: 'success');
        $this->dispatch('event-visitor-added');
    }

    public function setMember()
    {
        $member = Member::findOrFail($this->form->member_id);
        $this->form->member_id = $member->id;
        $this->form->name = $member->fullName();
        $this->form->email = $member->email;
        $this->form->phone = $member->phone;
        $this->form->gender = $member->gender;
        $this->reset('form.event_subscription_id');

    }

    public function setSubscriber()
    {
        $subscription = EventSubscription::findOrFail($this->form->event_subscription_id);
        $this->form->event_subscription_id = $subscription->id;
        $this->form->name = $subscription->name;
        $this->form->email = $subscription->email;
        $this->form->phone = $subscription->phone;
        $this->reset('form.member_id');
    }

    public function render()
    {
        return view('livewire.event.visitor.create.form');
    }
}
