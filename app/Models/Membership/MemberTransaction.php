<?php

namespace App\Models\Membership;

use App\Models\Accounting\Transaction;
use App\Models\Event\Event;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $member_id
 * @property int $transaction_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Event|null $event
 * @property-read Member|null $member
 * @property-read Transaction|null $transaction
 *
 * @method static Builder<static>|MemberTransaction newModelQuery()
 * @method static Builder<static>|MemberTransaction newQuery()
 * @method static Builder<static>|MemberTransaction query()
 * @method static Builder<static>|MemberTransaction whereCreatedAt($value)
 * @method static Builder<static>|MemberTransaction whereId($value)
 * @method static Builder<static>|MemberTransaction whereMemberId($value)
 * @method static Builder<static>|MemberTransaction whereTransactionId($value)
 * @method static Builder<static>|MemberTransaction whereUpdatedAt($value)
 *
 * @property Carbon|null $receipt_sent_timestamp
 *
 * @method static Builder<static>|MemberTransaction whereReceiptSentTimestamp($value)
 *
 * @mixin Eloquent
 */
class MemberTransaction extends Model
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

    protected $casts = [
        'date' => 'date',
        'receipt_sent_timestamp' => 'datetime',
    ];
}
