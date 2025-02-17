<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventSubscription extends Model
{
    /** @use HasFactory<\Database\Factories\EventSubscriptionFactory> */
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'remarks',
        'brings_guests', 'amount_guests', 'event_id', 'confirmed_at'
        ,'consentNotification'
    ];

    protected $casts = [
        'consentNotification' => 'boolean',
        'brings_guests' => 'boolean',
        'confirmed_at' => 'datetime',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
