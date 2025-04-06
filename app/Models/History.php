<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $historable_type
 * @property int $historable_id
 * @property int|null $user_id
 * @property string $action
 * @property string|null $changes
 * @property string $changed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History whereChangedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History whereChanges($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History whereHistorableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History whereHistorableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|History whereUserId($value)
 *
 * @mixin \Eloquent
 */
class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'historable_id',
        'historable_type',
        'user_id',
        'action',
        'changes',
        'changed_at',
        'created_at',
        'updated_at',
    ];
}
