<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory;

    protected $guarded=[];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function grossForHumans():string{

        return number_format(($this->amount_gross/100),2,',','.');
    }
}
