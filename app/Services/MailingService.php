<?php


namespace App\Services;

use App\Models\MailingList;
use App\Models\Membership\Member;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;
use App\Notifications\EventPublishedNotification;
use App\Notifications\PostPublishedNotification;

class MailingService
{
    /**
     * Send notifications to subscribers for a given notification type.
     *
     * @param  string  $notificationType  'event' or 'post'
     * @param  mixed  $notifiable  The notifiable entity (e.g., Event or BlogPost model)
     * @param  string  $subject  The email subject
     * @param  string  $view  The Blade view for the email
     * @param  array  $data  Data to pass to the email view
     * @return void
     */
    public function sendNotificationsToSubscribers(string $notificationType, $notifiable, string $subject, string $view, array $data = []): void
    {
        // Notify backend users via Laravel Notification system
        $this->notifyBackendUsers($notificationType, $notifiable);

        // Fetch unique email recipients (members + mailing list subscribers, deduplicated)
        $emailRecipients = $this->getUniqueEmailRecipients($notificationType);

        // Send emails to members and mailing list subscribers
        foreach ($emailRecipients as $recipient) {
            Log::info("Sending email to ", ['data' => $recipient]);
            $recipientData = array_merge($data, [
                'notificationType' => $notificationType,
                'notifiable' => $notifiable,
                'recipient' => $recipient, // Pass the entire recipient array
            ]);

            Mail::to($recipient['email'])
                ->queue(new \App\Mail\CustomNotificationMail(
                    $subject,
                    $view,
                    $recipientData
                ));
        }
    }

    /**
     * Notify backend users via Laravel's Notification system.
     *
     * @param  string  $notificationType
     * @param  mixed  $notifiable
     * @return void
     */
    protected function notifyBackendUsers(string $notificationType, $notifiable): void
    {
        $users = User::whereNotNull('email')
            ->where('email', '!=', '')
            ->get();

        if ($notificationType === 'event') {
            Notification::send($users, new EventPublishedNotification($notifiable));
        } elseif ($notificationType === 'post') {
            Notification::send($users, new PostPublishedNotification($notifiable));
        }
    }

    /**
     * Get a collection of unique email recipients (members and mailing list subscribers).
     *
     * @param  string  $notificationType
     * @return Collection
     */
    protected function getUniqueEmailRecipients(string $notificationType): Collection
    {
        // Fetch members with email addresses (they get all notifications)
        $members = Member::whereNotNull('email')
            ->where('email', '!=', '')
            ->select('id', 'email', 'locale')
            ->get()
            ->map(function ($member) {
                return ['id' => $member->id, 'email' => $member->email, 'type' => 'member', 'locale' => $member->locale];
            });

        // Fetch mailing list subscribers based on notification type
        $subscribersQuery = MailingList::whereNotNull('email')
            ->where('email', '!=', '');

        if ($notificationType === 'event') {
            $subscribersQuery->where('update_on_events', true);
        } elseif ($notificationType === 'post') {
            $subscribersQuery->where('update_on_articles', true);
        }

        $subscribers = $subscribersQuery->select('id', 'email', 'verification_token', 'verified_at', 'locale')
            ->get()
            ->map(function ($subscriber) {
                return [
                    'id' => $subscriber->id,
                    'email' => $subscriber->email,
                    'type' => 'subscriber',
                    'verification_token' => $subscriber->verification_token,
                    'verified_at' => $subscriber->verified_at,
                    'locale' => $subscriber->locale->value,
                ];
            });

        // Merge and deduplicate based on email
        return $members->merge($subscribers)
            ->unique('email')
            ->values();
    }
}
