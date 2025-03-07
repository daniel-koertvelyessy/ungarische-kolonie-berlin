<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string|null $file_name
 * @property string|null $file_name_original
 * @property int $transaction_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Accounting\Transaction|null $transaction
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Receipt newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Receipt newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Receipt query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Receipt whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Receipt whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Receipt whereFileNameOriginal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Receipt whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Receipt whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Receipt whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Receipt extends Model
{
    /** @use HasFactory<\Database\Factories\ReceiptFactory> */
    use HasFactory;

    protected $guarded = [];

    public function transaction(): BelongsTo
    {
        return $this->BelongsTo(Transaction::class);
    }

    public function download()
    {
        // TODO : $this->file_name;
    }
}
