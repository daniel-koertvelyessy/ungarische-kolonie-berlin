<?php

namespace App\Notifications;

use App\Models\Membership\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MemberAcceptedNotification extends Notification
{
    use Queueable;

    public $member;

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
        app()->setLocale($this->member->locale);

        return (new MailMessage)
            ->from('szia@magyar-kolonia-berlin.org', 'Daniel Körtvélyessy')
            ->view(
                'emails.member-acceptance', ['member' => $this->member]
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
            'applied_at' => $this->member->applied_at,
            'fullName' => $this->member->name.', '.$this->member->first_name,
        ];
    }
}
