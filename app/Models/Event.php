<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'title' => 'array',
        'slug' => 'array',
        'description' => 'array',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

}
