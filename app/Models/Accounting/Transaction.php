<?php

declare(strict_types=1);

namespace App\Models\Accounting;

use App\Enums\TransactionType;
use App\Models\Event\EventTransaction;
use App\Models\Event\EventVisitor;
use App\Models\Membership\Member;
use App\Models\Membership\MemberTransaction;
use App\Models\Traits\HasHistory;
use Database\Factories\Accounting\TransactionFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Carbon $date
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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Account $account
 * @property-read EventTransaction|null $event_transaction
 * @property-read MemberTransaction|null $member_transaction
 * @property-read Member|null $members
 * @property-read Collection<int, Receipt> $receipts
 * @property-read int|null $receipts_count
 * @property-read Collection<int, EventVisitor> $visitors
 * @property-read int|null $visitors_count
 *
 * @method static TransactionFactory factory($count = null, $state = [])
 * @method static Builder<static>|Transaction newModelQuery()
 * @method static Builder<static>|Transaction newQuery()
 * @method static Builder<static>|Transaction query()
 * @method static Builder<static>|Transaction whereAccountId($value)
 * @method static Builder<static>|Transaction whereAmountGross($value)
 * @method static Builder<static>|Transaction whereAmountNet($value)
 * @method static Builder<static>|Transaction whereBookingAccountId($value)
 * @method static Builder<static>|Transaction whereCreatedAt($value)
 * @method static Builder<static>|Transaction whereDate($value)
 * @method static Builder<static>|Transaction whereDescription($value)
 * @method static Builder<static>|Transaction whereId($value)
 * @method static Builder<static>|Transaction whereLabel($value)
 * @method static Builder<static>|Transaction whereReference($value)
 * @method static Builder<static>|Transaction whereStatus($value)
 * @method static Builder<static>|Transaction whereTax($value)
 * @method static Builder<static>|Transaction whereType($value)
 * @method static Builder<static>|Transaction whereUpdatedAt($value)
 * @method static Builder<static>|Transaction whereVat($value)
 *
 * @property-read Collection<int, \App\Models\History> $histories
 * @property-read int|null $histories_count
 *
 * @mixin Eloquent
 */
final class Transaction extends Model
{
    /** @use HasFactory<TransactionFactory> */
    use HasFactory;

    use HasHistory;

    protected $guarded = [];

    protected $casts = [
        'date' => 'datetime',
        'amount_gross' => 'integer',
        'amount_net' => 'integer',
    ];

    private TransactionHelper $transactionHelper;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->transactionHelper = new TransactionHelper($this);
    }

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
        return $this->transactionHelper->grossForHumans();
    }

    public function taxForHumans(): string
    {
        return $this->transactionHelper->taxForHumans();
    }

    public function netForHumans(): string
    {
        return $this->transactionHelper->netForHumans();
    }

    public function grossColor(): string
    {
        return TransactionType::color($this->type);
    }
}
