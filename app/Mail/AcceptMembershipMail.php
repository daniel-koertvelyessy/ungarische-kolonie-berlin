<?php

namespace App\Mail;

use App\Models\Membership\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AcceptMembershipMail extends Mailable
{
    use Queueable, SerializesModels;

    public Member $member;

    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    /*    public function build(): AcceptMembershipMail
        {
            return $this->subject(__('mails.acceptance.subject'))
                ->from('szia@magyar-kolonia-berlin.org', 'Körtvélyessy Daniel')
                ->view('emails.member-acceptance', ['member' => $this->member]);
        }*/

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: 'szia@magyar-kolonia-berlin.org',
            subject: __('mails.acceptance.subject'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.member-acceptance',
            with: ['member' => $this->member]
        );
    }
}
