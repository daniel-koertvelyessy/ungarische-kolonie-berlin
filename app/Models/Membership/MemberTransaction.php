<?php

namespace App\Models\Membership;

use App\Models\Accounting\Transaction;
use App\Models\Event\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function amountForHumans(): string
    {
        return number_format(($this->amount / 100), 2, ',', '.');
    }

    protected $casts = [
        'date' => 'date',
    ];
}
