<?php

namespace App\Models\Event;

use App\Enums\TransactionType;
use App\Models\Accounting\Transaction;
use App\Models\Membership\Member;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function amountForHumans(): string
    {
        $value = $this->amount / 100 * TransactionType::calc($this->transaction->type);

        return number_format(($value), 2, ',', '.');
    }
}
