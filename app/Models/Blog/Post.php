<?php

namespace App\Models\Blog;

use App\Enums\EventStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property array<array-key, mixed> $title
 * @property array<array-key, mixed> $slug
 * @property array<array-key, mixed> $body
 * @property int $user_id
 * @property string $status
 * @property int $post_type_id
 * @property string|null $label
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Blog\PostImage> $images
 * @property-read int|null $images_count
 * @property-read \App\Models\Blog\PostType|null $type
 * @property-read User $user
 *
 * @method static \Database\Factories\Blog\PostFactory factory($count = null, $state = [])
 * @method static Builder<static>|Post newModelQuery()
 * @method static Builder<static>|Post newQuery()
 * @method static Builder<static>|Post query()
 * @method static Builder<static>|Post whereBody($value)
 * @method static Builder<static>|Post whereCreatedAt($value)
 * @method static Builder<static>|Post whereId($value)
 * @method static Builder<static>|Post whereLabel($value)
 * @method static Builder<static>|Post wherePostTypeId($value)
 * @method static Builder<static>|Post wherePublishedAt($value)
 * @method static Builder<static>|Post whereSlug($value)
 * @method static Builder<static>|Post whereStatus($value)
 * @method static Builder<static>|Post whereTitle($value)
 * @method static Builder<static>|Post whereUpdatedAt($value)
 * @method static Builder<static>|Post whereUserId($value)
 *
 * @mixin \Eloquent
 */
class Post extends Model
{
    /** @use HasFactory<\Database\Factories\Blog\PostFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'user_id',
        'status',
        'label',
        'published_at',
        'post_type_id',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'title' => 'array',
        'slug' => 'array',
        'body' => 'array',
    ];

    /*    public function setTitleAttribute($value): void
        {
            $this->attributes['title'] = json_encode($value, JSON_UNESCAPED_UNICODE);
    //        $this->attributes['slug'] = json_encode([
    //            'hu' => Str::slug($value['hu']),
    //            'de' => Str::slug($value['de']),
    //        ], JSON_UNESCAPED_UNICODE);
        }

        public function getTitleAttribute($value): string
        {
    //      $sn = json_decode($value, true);
    //      return $sn[app()->getLocale()];
            return json_decode($value, true);
        }

        public function getSlugAttribute($value): string
        {
            return json_decode($value, true)[app()->getLocale()];
        }

        public function getContentAttribute($value): string
        {
            return json_decode($value, true);
        }*/

    public function isPublished(): bool
    {
        return $this->status === 'published' || $this->published_at !== null;

    }

    public function status_color()
    {
        return EventStatus::color($this->status);
    }

    public function typeColor()
    {
        return $this->type->color;
    }

    public function type(): HasOne
    {
        return $this->hasOne(PostType::class, 'id', 'post_type_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function excerpt($limit = 100): string
    {
        $text = preg_replace('/<\/?(p|div|br|li|h[1-6])\b[^>]*>/', ' ', $this->body[app()->getLocale()]);
        $excerpt = trim(strip_tags($text));

        return Str::limit($excerpt, $limit, '...', true);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PostImage::class);
    }
}
