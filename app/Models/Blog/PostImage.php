<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    protected $fillable = ['post_id', 'filename', 'original_filename', 'caption', 'author'];

    protected $casts = [
        'caption' => 'array',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
