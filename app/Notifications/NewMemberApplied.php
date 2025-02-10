<?php

namespace App\Notifications;

use App\Models\Membership\Member;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMemberApplied extends Notification //implements ShouldQueue
{
    // use Queueable;

    protected $member;

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
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {

        return (new MailMessage)
            ->from('hallo@ungarische-kolonie-berlin.org', 'Daniel Körtvélyessy')
            ->view(
            'emails.member-application', ['member' => $this->member]
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
            'fullName' => $this->member->name . ', ' . $this->member->first_name
        ];
    }
}
