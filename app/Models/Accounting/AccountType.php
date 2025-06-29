<?php

declare(strict_types=1);

namespace App\Models\Accounting;

use Database\Factories\Accounting\AccountTypeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $name
 *
 * @method static Builder<static>|AccountType newModelQuery()
 * @method static Builder<static>|AccountType newQuery()
 * @method static Builder<static>|AccountType query()
 * @method static Builder<static>|AccountType whereCreatedAt($value)
 * @method static Builder<static>|AccountType whereId($value)
 * @method static Builder<static>|AccountType whereName($value)
 * @method static Builder<static>|AccountType whereUpdatedAt($value)
 * @method static \Database\Factories\Accounting\AccountTypeFactory factory($count = null, $state = [])
 *
 * @mixin Eloquent
 */
class AccountType extends Model
{
    /** @use HasFactory<AccountTypeFactory> */
    use HasFactory;
}
