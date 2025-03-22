<?php

namespace App\Models\Accounting;

use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use Database\Factories\Accounting\AccountFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $number
 * @property string $type
 * @property string|null $institute
 * @property string|null $iban
 * @property string|null $bic
 * @property int $starting_amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, AccountReport> $reports
 * @property-read int|null $reports_count
 * @property-read Collection<int, Transaction> $transactions
 * @property-read int|null $transactions_count
 *
 * @method static Builder<static>|Account newModelQuery()
 * @method static Builder<static>|Account newQuery()
 * @method static Builder<static>|Account query()
 * @method static Builder<static>|Account whereBic($value)
 * @method static Builder<static>|Account whereCreatedAt($value)
 * @method static Builder<static>|Account whereIban($value)
 * @method static Builder<static>|Account whereId($value)
 * @method static Builder<static>|Account whereInstitute($value)
 * @method static Builder<static>|Account whereName($value)
 * @method static Builder<static>|Account whereNumber($value)
 * @method static Builder<static>|Account whereStartingAmount($value)
 * @method static Builder<static>|Account whereType($value)
 * @method static Builder<static>|Account whereUpdatedAt($value)
 * @method static \Database\Factories\Accounting\AccountFactory factory($count = null, $state = [])
 *
 * @mixin Eloquent
 */
class Account extends Model
{
    /** @use HasFactory<AccountFactory> */
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

    public static function makeCentInteger($formattedValue): int
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
