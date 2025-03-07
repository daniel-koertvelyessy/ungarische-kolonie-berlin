<?php

namespace App\Models\Accounting;

use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $number
 * @property string $type
 * @property string|null $institute
 * @property string|null $iban
 * @property string|null $bic
 * @property int $starting_amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Accounting\AccountReport> $reports
 * @property-read int|null $reports_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Accounting\Transaction> $transactions
 * @property-read int|null $transactions_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereBic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereInstitute($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereStartingAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Account whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
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
