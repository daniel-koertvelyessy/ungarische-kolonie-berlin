<?php

namespace App\Models\Blog;

use App\Enums\EventStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

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

    public function images()
    {
        return $this->hasMany(PostImage::class);
    }
}
