<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\Blog\PostFactory> */
    use HasFactory;

    protected $casts = [
        'title' => 'array',
        'slug' => 'array',
        'content' => 'array',
    ];

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = json_encode($value, JSON_UNESCAPED_UNICODE);
        $this->attributes['slug'] = json_encode([
            'hu' => Str::slug($value['hu']),
            'de' => Str::slug($value['de'])
        ], JSON_UNESCAPED_UNICODE);
    }

    public function getTitleAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getSlugAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getContentAttribute($value)
    {
        return json_decode($value, true);
    }
}
