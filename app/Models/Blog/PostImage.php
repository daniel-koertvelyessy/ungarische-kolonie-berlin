<?php

declare(strict_types=1);

namespace App\Models\Blog;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property array<array-key, mixed>|null $caption
 * @property string $filename
 * @property string $original_filename
 * @property int $post_id
 * @property string|null $author
 * @property-read Post $post
 *
 * @method static Builder<static>|PostImage newModelQuery()
 * @method static Builder<static>|PostImage newQuery()
 * @method static Builder<static>|PostImage query()
 * @method static Builder<static>|PostImage whereAuthor($value)
 * @method static Builder<static>|PostImage whereCaption($value)
 * @method static Builder<static>|PostImage whereCreatedAt($value)
 * @method static Builder<static>|PostImage whereFilename($value)
 * @method static Builder<static>|PostImage whereId($value)
 * @method static Builder<static>|PostImage whereOriginalFilename($value)
 * @method static Builder<static>|PostImage wherePostId($value)
 * @method static Builder<static>|PostImage whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
class PostImage extends Model
{
    protected $fillable = ['post_id', 'filename', 'original_filename', 'caption', 'author'];

    protected $casts = [
        'caption' => 'array',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
