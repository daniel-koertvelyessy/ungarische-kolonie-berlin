<?php

namespace App\Models\Accounting;

use Database\Factories\ReceiptFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string|null $file_name
 * @property string|null $file_name_original
 * @property int $transaction_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Transaction|null $transaction
 *
 * @method static Builder<static>|Receipt newModelQuery()
 * @method static Builder<static>|Receipt newQuery()
 * @method static Builder<static>|Receipt query()
 * @method static Builder<static>|Receipt whereCreatedAt($value)
 * @method static Builder<static>|Receipt whereFileName($value)
 * @method static Builder<static>|Receipt whereFileNameOriginal($value)
 * @method static Builder<static>|Receipt whereId($value)
 * @method static Builder<static>|Receipt whereTransactionId($value)
 * @method static Builder<static>|Receipt whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class Receipt extends Model
{
    /** @use HasFactory<ReceiptFactory> */
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
