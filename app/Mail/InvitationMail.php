<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invitation;

    public function __construct($invitation)
    {
        $this->invitation = $invitation;
    }

    public function build(): InvitationMail
    {
        return $this->subject('Meghívás a Magyar Kolónia Berlin e.V.')
            ->from('szia@magyar-kolonia-berlin.org', 'Körtvélyessy Daniel')
            ->view('emails._invitation')
            ->with([
                'url' => route('register', ['token' => $this->invitation->token]),
            ]);
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: 'szia@magyar-kolonia-berlin.org',
            subject: 'Meghívás a Magyar Kolónia Berlin e.V.',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invitation',
            with:[ 'url' => route('register', ['token' => $this->invitation->token])],
        );
    }


}
