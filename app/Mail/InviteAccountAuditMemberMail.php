<?php

declare(strict_types=1);

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

class InviteAccountAuditMemberMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(public Member $member, public AccountReport $accountReport, public AccountReportAudit $accountReportAudit) {}

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
                'accountReport' => $this->accountReport,
                'url' => route('account-report.audit', ['account_report_audit' => $this->accountReportAudit]),
            ],
        );
    }
}
