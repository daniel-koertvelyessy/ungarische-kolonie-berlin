<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $type
 * @property string $number
 * @property string $label
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookingAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookingAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookingAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookingAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookingAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookingAccount whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookingAccount whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookingAccount whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BookingAccount whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class BookingAccount extends Model
{
    /**
     *   Standardkontenrahmen 49
     *   https://www.standardkontenrahmen.de/skr49
     */

    /** @use HasFactory<\Database\Factories\BookingAccountFactory> */
    use HasFactory;

    protected $fillable = [
        'label',
        'number',
        'type',
    ];
}
