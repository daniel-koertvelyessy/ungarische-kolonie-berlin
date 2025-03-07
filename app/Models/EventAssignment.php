<?php

namespace App\Models;

use App\Enums\AssignmentStatus;
use App\Models\Event\Event;
use App\Models\Membership\Member;
use Database\Factories\EventAssignmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

/**
 * @method static EventAssignment create(array $attributes)
 *
 * @property int $id
 * @property string $task
 * @property string $status
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $due_at
 * @property int|null $amount
 * @property int $event_id
 * @property int $member_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Event $event
 * @property-read Member $member
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\User $user
 *
 * @method static \Database\Factories\EventAssignmentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAssignment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAssignment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAssignment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAssignment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAssignment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAssignment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAssignment whereDueAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAssignment whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAssignment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAssignment whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAssignment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAssignment whereTask($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAssignment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventAssignment whereUserId($value)
 *
 * @mixin \Eloquent
 */
class EventAssignment extends Model
{
    /** @use HasFactory<EventAssignmentFactory> */
    use HasFactory, Notifiable;

    protected $guarded = [];

    protected $casts = [
        'due_at' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function statusColor(): string
    {
        return AssignmentStatus::color($this->status);
    }

    public function statusLabel(): string
    {
        return AssignmentStatus::value($this->status);
    }

    public function getDueString(): string
    {
        return $this->due_at->isPast() ? $this->due_at->format('Y-m-d') : $this->due_at->diffForHumans();

    }

    public function amountString(): string
    {
        return $this->amount
        ? number_format($this->amount / 100, 2, ',', '.').' EUR'
            : '-,--';
    }
}
