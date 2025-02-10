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

    public $invitation;
    public $member;

    public function __construct(Invitation $invitation, Member $member)
    {
        $this->invitation = $invitation;
        $this->member = $member;
    }

    public function build(): InvitationMail
    {
        return $this->subject('Meghívás a Magyar Kolónia Berlin e.V.')
            ->from('szia@magyar-kolonia-berlin.org', 'Körtvélyessy Daniel')
            ->view('emails._invitation', [ 'member' => $this->member])
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
