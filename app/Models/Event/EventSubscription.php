<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string|null $remarks
 * @property bool $brings_guests
 * @property bool $consentNotification
 * @property int $amount_guests
 * @property int $event_id
 * @property \Illuminate\Support\Carbon|null $confirmed_at
 * @property-read \App\Models\Event\Event|null $event
 *
 * @method static \Database\Factories\Event\EventSubscriptionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSubscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSubscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSubscription query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSubscription whereAmountGuests($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSubscription whereBringsGuests($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSubscription whereConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSubscription whereConsentNotification($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSubscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSubscription whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSubscription whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSubscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSubscription whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSubscription wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSubscription whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSubscription whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class EventSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'remarks',
        'brings_guests', 'amount_guests', 'event_id', 'confirmed_at', 'consentNotification',
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
