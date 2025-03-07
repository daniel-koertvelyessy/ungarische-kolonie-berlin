<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property string $email
 * @property int|null $member_id
 *
 * @method static \Database\Factories\MailinglistFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mailinglist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mailinglist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mailinglist query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mailinglist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mailinglist whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mailinglist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mailinglist whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mailinglist whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mailinglist whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Mailinglist extends Model
{
    /** @use HasFactory<\Database\Factories\MailinglistFactory> */
    use HasFactory;
}
