<?php

namespace App\Models\Event;

use App\Models\Accounting\Transaction;
use App\Models\Membership\Member;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string|null $visitor_name
 * @property string|null $gender
 * @property int $transaction_id
 * @property int $event_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Event\Event|null $event
 * @property-read Member|null $member
 * @property-read Transaction|null $transaction
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventTransaction whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventTransaction whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventTransaction whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventTransaction whereVisitorName($value)
 *
 * @mixin \Eloquent
 */
class EventTransaction extends Model
{
    protected $guarded = [];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
