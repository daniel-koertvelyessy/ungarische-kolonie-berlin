<?php

namespace App\Mail;

use App\Models\MailingList;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class ConfirmMailingListSubscription extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public MailingList $mailingList) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: 'szia@magyar-kolonia-berlin.org',
            subject: __('mails.mailing_list.confirmation_email_subject'),
        );
    }


    public function content(): Content
    {

       return new Content(
            view: 'emails.confirm_mailing_list_subscription',
            with: [
                'mailingList' => $this->mailingList,
                'url' => route('mailing-list.show', $this->mailingList->verification_token),
                'locale' => $this->mailingList->locale->value,
            ],

        );

    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
