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
        'type',
        'institute',
        'iban',
        'bic',
        'starting_amount',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function accountBalance(): int
    {

        $current = $this->starting_amount ?? 0;

        foreach (Transaction::where('account_id', $this->id)->get() as $transaction) {
            $current += $transaction->status === TransactionStatus::booked->value ? $transaction->amount_gross * TransactionType::calc($transaction->type) : 0;
        }

        return $current;
    }

    public static function makeCentInteger($formattedValue)
    {
        // Remove all non-numeric characters except commas
        $value = preg_replace('/[^\d,]/', '', $formattedValue);

        // Replace comma with a dot for decimal conversion
        $n = str_replace(',', '', $value, $count);

        return (int) $n;
    }

    public static function formatedAmount(int $value): string
    {
        return number_format($value / 100, 2, ',', '.');
    }

    public function reports(): HasMany
    {
        return $this->hasMany(AccountReport::class);
    }
}
