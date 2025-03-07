<?php

namespace App\Models\Accounting;

use App\Enums\TransactionType;
use App\Models\Event\EventTransaction;
use App\Models\Event\EventVisitor;
use App\Models\Membership\Member;
use App\Models\Membership\MemberTransaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property \Illuminate\Support\Carbon $date
 * @property string $label
 * @property string|null $reference
 * @property string|null $description
 * @property int $amount_gross
 * @property int $vat
 * @property int|null $tax
 * @property int $amount_net
 * @property int $account_id
 * @property int|null $booking_account_id
 * @property string $type
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Accounting\Account $account
 * @property-read EventTransaction|null $event_transaction
 * @property-read MemberTransaction|null $member_transaction
 * @property-read Member|null $members
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Accounting\Receipt> $receipts
 * @property-read int|null $receipts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, EventVisitor> $visitors
 * @property-read int|null $visitors_count
 *
 * @method static \Database\Factories\Accounting\TransactionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereAmountGross($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereAmountNet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereBookingAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Transaction whereVat($value)
 *
 * @mixin \Eloquent
 */
class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\Accounting\TransactionFactory> */
    use HasFactory;

    protected int $decimals = 2;

    protected string $komma = ',';

    protected string $tausender = '.';

    protected $guarded = [];

    protected $casts = [
        'date' => 'datetime',
        'amount_gross' => 'integer',
        'amount_net' => 'integer',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function receipts(): hasMany
    {
        return $this->hasMany(Receipt::class);
    }

    public function event_transaction(): HasOne
    {
        return $this->hasOne(EventTransaction::class);
    }

    public function member_transaction(): HasOne
    {
        return $this->hasOne(MemberTransaction::class);
    }

    public function members(): belongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function visitors(): HasMany
    {
        return $this->hasMany(EventVisitor::class);
    }

    public function grossForHumans(): string
    {
        return number_format(($this->amount_gross / 100), $this->decimals, $this->komma, $this->tausender);
    }

    public function taxForHumans(): string
    {
        return number_format(($this->tax / 100), $this->decimals, $this->komma, $this->tausender);
    }

    public function netForHumans(): string
    {
        return number_format(($this->amount_net / 100), $this->decimals, $this->komma, $this->tausender);
    }

    public function grossColor(): string
    {
        if ($this->type === TransactionType::Deposit->value) {
            return 'positive';
        } else {
            return 'negative';
        }
    }
}
