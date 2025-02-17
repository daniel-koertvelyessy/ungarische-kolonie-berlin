<?php

namespace App\Models;

use App\Models\Accounting\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

    protected $fillable=[
        'event_date',
        'start_time',
        'end_time',
        'title',
        'slug',
        'excerpt',
        'description',
        'image',
        'status',
        'entry_fee',
        'entry_fee_discounted',
        'venue_id'
    ];
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

    public function subscriptions(): HasMany
    {
        return $this->hasMany(EventSubscription::class);
    }


}
