<?php

namespace App\Models\Accounting;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $reason
 * @property int $user_id
 * @property int $transaction_id
 * @property string $status
 * @property-read \App\Models\Accounting\Transaction|null $transaction
 * @property-read User|null $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CancelTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CancelTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CancelTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CancelTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CancelTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CancelTransaction whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CancelTransaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CancelTransaction whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CancelTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CancelTransaction whereUserId($value)
 *
 * @mixin \Eloquent
 */
class CancelTransaction extends Model
{
    protected $guarded = [];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
