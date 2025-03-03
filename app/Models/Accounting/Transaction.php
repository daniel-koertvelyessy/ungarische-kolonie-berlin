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
