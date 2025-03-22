<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder<static>|Article newModelQuery()
 * @method static Builder<static>|Article newQuery()
 * @method static Builder<static>|Article query()
 * @method static Builder<static>|Article whereCreatedAt($value)
 * @method static Builder<static>|Article whereId($value)
 * @method static Builder<static>|Article whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class Article extends Pivot
{
    //
}
