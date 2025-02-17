<?php

namespace App\Mail;

use App\Models\EventSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConfirmEventSubscription extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    use SerializesModels;

    public $subscription;
    public $token;

    public function __construct(EventSubscription $subscription, $token)
    {
        $this->subscription = $subscription;
        $this->token = $token;
    }

    public function build()
    {
        return $this->subject('Bitte bestätige deine Anmeldung')
            ->from('szia@magyar-kolonia-berlin.org', 'Körtvélyessy, Daniel')
            ->view('emails.confirm-event-subscription')
            ->with([
                'confirmUrl' => route('event.subscription.confirm', ['id' => $this->subscription->id, 'token' => $this->token]),
            ]);
    }
}
