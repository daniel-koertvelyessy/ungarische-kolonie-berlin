<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostType extends Model
{


    protected $fillable = [
        'name',
        'slug',
        'description',
        'color'
    ];


    protected $casts = [
      'name' => 'array',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function color():string
    {
        return $this->color;
    }

}
