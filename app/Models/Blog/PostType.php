<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property array<array-key, mixed> $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Blog\Post|null $post
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostType whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostType whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class PostType extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
    ];

    protected $casts = [
        'name' => 'array',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function color(): string
    {
        return $this->color;
    }
}
