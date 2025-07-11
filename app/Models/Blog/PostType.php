<?php

declare(strict_types=1);

namespace App\Models\Blog;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property array<array-key, mixed> $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $color
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Post|null $post
 *
 * @method static Builder<static>|PostType newModelQuery()
 * @method static Builder<static>|PostType newQuery()
 * @method static Builder<static>|PostType query()
 * @method static Builder<static>|PostType whereColor($value)
 * @method static Builder<static>|PostType whereCreatedAt($value)
 * @method static Builder<static>|PostType whereDescription($value)
 * @method static Builder<static>|PostType whereId($value)
 * @method static Builder<static>|PostType whereName($value)
 * @method static Builder<static>|PostType whereSlug($value)
 * @method static Builder<static>|PostType whereUpdatedAt($value)
 * @method static \Database\Factories\Blog\PostTypeFactory factory($count = null, $state = [])
 *
 * @mixin Eloquent
 */
class PostType extends Model
{
    use HasFactory;

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
