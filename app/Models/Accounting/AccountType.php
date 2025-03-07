<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AccountType whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class AccountType extends Model
{
    /** @use HasFactory<\Database\Factories\AccountTypeFactory> */
    use HasFactory;
}
