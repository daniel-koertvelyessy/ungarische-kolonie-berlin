<?php

namespace App\Models\Event;

use App\Models\Accounting\Transaction;
use App\Models\Membership\Member;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property string|null $email
 * @property string|null $phone
 * @property int $event_id
 * @property string $gender
 * @property int|null $transaction_id
 * @property int|null $member_id
 * @property int|null $event_subscription_id
 * @property-read \App\Models\Event\Event|null $event
 * @property-read Member|null $member
 * @property-read Transaction|null $transaction
 *
 * @method static \Database\Factories\Event\EventVisitorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventVisitor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventVisitor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventVisitor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventVisitor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventVisitor whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventVisitor whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventVisitor whereEventSubscriptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventVisitor whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventVisitor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventVisitor whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventVisitor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventVisitor wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventVisitor whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventVisitor whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class EventVisitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'event_id',
        'subscription_id',
        'member_id',
        'transaction_id',
        'gender',
        'event_subscription_id',
    ];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
