<?php

namespace App\Livewire\Event\Subscription\Create;

use App\Mail\ConfirmEventSubscription;
use App\Models\Event\EventSubscription;
use Flux\Flux;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Form extends Component
{
    public $eventId;

    public $name;

    public $email;

    public $phone;

    public $remarks;

    public $bringsGuests = false;

    public $consentNotification = false;

    public $amountGuests = 0;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'remarks' => 'nullable|string',
        'bringsGuests' => 'boolean',
        'consentNotification' => 'boolean',
        'amountGuests' => 'nullable|integer|min:0|max:10',
    ];

    protected $messages = [
        'name.required' => 'Bitte einen Namen angeben',
        'email.required' => 'Wir benötigen Ihre E-Mail Adresse',
        'email.unique' => 'Überprüfe, ob du schon eine E-Mail von uns erhalten hast.',
    ];

    public function subscribe(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('event_subscriptions')->where(function ($query) {
                    return $query->where('event_id', $this->eventId);
                }),
            ],
            'phone' => 'nullable|string|max:20',
            'remarks' => 'nullable|string',
            'bringsGuests' => 'boolean',
            'consentNotification' => 'boolean',
            'amountGuests' => 'nullable|integer|min:0|max:10',
        ]);

        $subscription = EventSubscription::create([
            'event_id' => $this->eventId,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'remarks' => $this->remarks,
            'brings_guests' => $this->bringsGuests,
            'consentNotification' => $this->consentNotification,
            'amount_guests' => $this->bringsGuests ? $this->amountGuests : 0,
        ]);

        // Bestätigungsmail senden
        $token = Str::random(32);
        cache()->put("event_subscription_{$subscription->id}_token", $token, now()->addHours(24));

        Mail::to($subscription->email)->send(new ConfirmEventSubscription($subscription, $token));

        Flux::toast(__('event.subscription.confirm_subscription_message'));

    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.event.subscription.create.form');
    }
}
