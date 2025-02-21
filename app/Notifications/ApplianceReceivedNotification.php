<?php

namespace App\Notifications;

use App\Models\Membership\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplianceReceivedNotification extends Notification
{
    use Queueable;

    protected Member $member;

    /**
     * Create a new notification instance.
     */
    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        app()->setLocale($this->member->locale ?? 'de');

        return (new MailMessage)
            ->subject(__('members.appliance_received.mail.subject'))
            ->from('szia@magyar-kolonia-berlin.org', 'Daniel Körtvélyessy')
            ->view(
                'emails.member-application-reply', ['member' => $this->member]
            );
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
