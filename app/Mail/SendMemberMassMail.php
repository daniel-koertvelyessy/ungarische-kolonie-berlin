<?php

namespace App\Mail;

use App\Models\Accounting\AccountReport;
use App\Models\Accounting\AccountReportAudit;
use App\Models\Membership\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMemberMassMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Member $member, public $subject, public $message) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: 'szia@magyar-kolonia-berlin.org',
            subject: __('mails.audit.invitation.subject'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invite-audit-member',
            with: [ // Pass variables here
                'member' => $this->member,
                'subject' => $this->subject,
                'message' => $this->message,
            ],
        );
    }
}
