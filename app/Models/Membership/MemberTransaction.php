<?php

namespace App\Models\Membership;

use App\Models\Accounting\Transaction;
use App\Models\Event\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $member_id
 * @property int $transaction_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Event|null $event
 * @property-read \App\Models\Membership\Member|null $member
 * @property-read Transaction|null $transaction
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberTransaction whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberTransaction whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberTransaction whereUpdatedAt($value)
 *
 * @property \Illuminate\Support\Carbon|null $receipt_sent_timestamp
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MemberTransaction whereReceiptSentTimestamp($value)
 *
 * @mixin \Eloquent
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
