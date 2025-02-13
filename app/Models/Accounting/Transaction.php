<?php

namespace App\Models\Accounting;

use App\Enums\TransactionType;
use App\Models\Membership\Member;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory;

    protected int $decimals = 2;
    protected string $komma = ',';
    protected string $tausender = '.';

    protected $guarded=[];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function receipts(): hasMany
    {
        return $this->hasMany(Receipt::class);
    }

    public function members(): belongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function grossForHumans():string{
        return number_format(($this->amount_gross/100),$this->decimals,$this->komma,$this->tausender);
    }
    public function taxForHumans():string{
        return number_format(($this->tax/100),$this->decimals,$this->komma,$this->tausender);
    }
    public function netForHumans():string{
        return number_format(($this->amount_net/100),$this->decimals,$this->komma,$this->tausender);
    }
    public function grossColor():string{
        if ($this->type === TransactionType::Deposit->value){
            return 'positive';
        } else {
            return 'negative';
        }
    }
}
