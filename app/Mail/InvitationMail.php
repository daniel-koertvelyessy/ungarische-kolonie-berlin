<?php

namespace App\Mail;

use App\Models\Membership\Invitation;
use App\Models\Membership\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvitationMail extends Mailable
{
    use Queueable, SerializesModels;


    public function __construct(public Invitation $invitation, public Member $member) {}

/*    public function build(): InvitationMail
    {
        return $this->subject(__('mails.invitation.subject'))
            ->from('szia@magyar-kolonia-berlin.org', 'Körtvélyessy Daniel')
            ->view('emails.invitation', ['member' => $this->member])
            ->with([
                'url' => route('register', ['token' => $this->invitation->token]),
            ]);
    }*/

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: 'szia@magyar-kolonia-berlin.org',
            subject: __('mails.invitation.subject'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invitation',
            with: ['url' => route('members.register', ['token' => $this->invitation->token])],
        );
    }
}
