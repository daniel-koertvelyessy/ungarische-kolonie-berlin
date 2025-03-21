<?php

namespace App\Models;

use App\Models\Event\Event;
use App\Models\Membership\Member;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $start
 * @property int|null $duration
 * @property string $end
 * @property int $event_id
 * @property string $title
 * @property string|null $description
 * @property string|null $notes
 * @property int|null $member_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $place
 * @property string|null $performer
 * @property-read Event $event
 * @property-read Member|null $member
 * @property-read \App\Models\User $user
 *
 * @method static \Database\Factories\EventTimelineFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventTimeline newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventTimeline newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventTimeline query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventTimeline whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventTimeline whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventTimeline whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventTimeline whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventTimeline whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventTimeline whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventTimeline whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventTimeline whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventTimeline wherePerformer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventTimeline wherePlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventTimeline whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventTimeline whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventTimeline whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventTimeline whereUserId($value)
 *
 * @property array<array-key, mixed>|null $title_extern
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventTimeline whereTitleExtern($value)
 *
 * @mixin \Eloquent
 */
class EventTimeline extends Model
{
    /** @use HasFactory<\Database\Factories\EventTimelineFactory> */
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'title_extern' => 'array',
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
}
