<?php

declare(strict_types=1);

namespace App\Models\Event;

use App\Models\Accounting\Transaction;
use App\Models\Membership\Member;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string|null $visitor_name
 * @property string|null $gender
 * @property int $transaction_id
 * @property int $event_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Event|null $event
 * @property-read Member|null $member
 * @property-read Transaction|null $transaction
 *
 * @method static Builder<static>|EventTransaction newModelQuery()
 * @method static Builder<static>|EventTransaction newQuery()
 * @method static Builder<static>|EventTransaction query()
 * @method static Builder<static>|EventTransaction whereCreatedAt($value)
 * @method static Builder<static>|EventTransaction whereEventId($value)
 * @method static Builder<static>|EventTransaction whereGender($value)
 * @method static Builder<static>|EventTransaction whereId($value)
 * @method static Builder<static>|EventTransaction whereTransactionId($value)
 * @method static Builder<static>|EventTransaction whereUpdatedAt($value)
 * @method static Builder<static>|EventTransaction whereVisitorName($value)
 *
 * @mixin Eloquent
 */
final class EventTransaction extends Model
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
