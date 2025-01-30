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

        'title' => 'array',
        'excerpt' => 'array',
        'slug' => 'array',
        'description' => 'array',
        'event_date' => 'date', // Cast as Carbon instance
        'start_time' => 'datetime:H:i:s', // Cast time as Carbon (only hours & minutes)
        'end_time' => 'datetime:H:i:s',
    ];

 /*   public function getRouteKeyName(): string
    {
        return 'slug';
    }*/

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

}
