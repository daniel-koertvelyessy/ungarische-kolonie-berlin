<?php

declare(strict_types=1);

namespace App\Models\Event;

use Database\Factories\Event\EventSubscriptionFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string|null $remarks
 * @property bool $brings_guests
 * @property bool $consentNotification
 * @property int $amount_guests
 * @property int $event_id
 * @property Carbon|null $confirmed_at
 * @property-read Event|null $event
 *
 * @method static EventSubscriptionFactory factory($count = null, $state = [])
 * @method static Builder<static>|EventSubscription newModelQuery()
 * @method static Builder<static>|EventSubscription newQuery()
 * @method static Builder<static>|EventSubscription query()
 * @method static Builder<static>|EventSubscription whereAmountGuests($value)
 * @method static Builder<static>|EventSubscription whereBringsGuests($value)
 * @method static Builder<static>|EventSubscription whereConfirmedAt($value)
 * @method static Builder<static>|EventSubscription whereConsentNotification($value)
 * @method static Builder<static>|EventSubscription whereCreatedAt($value)
 * @method static Builder<static>|EventSubscription whereEmail($value)
 * @method static Builder<static>|EventSubscription whereEventId($value)
 * @method static Builder<static>|EventSubscription whereId($value)
 * @method static Builder<static>|EventSubscription whereName($value)
 * @method static Builder<static>|EventSubscription wherePhone($value)
 * @method static Builder<static>|EventSubscription whereRemarks($value)
 * @method static Builder<static>|EventSubscription whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
final class EventSubscription extends Model
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

    public function event(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
