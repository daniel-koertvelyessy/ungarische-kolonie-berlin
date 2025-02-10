<?php

namespace App\Models\Accounting;

use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    /** @use HasFactory<\Database\Factories\AccountFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'number',
        'institute',
        'iban',
        'swift',
        'type',
        'starting_amount',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function accountBalance():int
    {
        $current = $this->starting_amount??0;

        foreach (Transaction::where('account_id',$this->id)->get() as $transaction) {
            $current += $transaction->status === TransactionStatus::booked->value ? $transaction->amount_gross * TransactionType::calc($transaction->type):0;
        }

        return $current;
    }

    public static function makeCentInteger($formattedValue): array|string|null
    {
        // Remove all non-numeric characters except commas
        $value = preg_replace('/[^\d,]/', '', $formattedValue);

        // Replace comma with a dot for decimal conversion
        $value = str_replace(',', '', $value);

        return (int) $value;
    }
}
