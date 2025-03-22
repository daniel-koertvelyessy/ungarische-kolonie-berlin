<?php

namespace App\Models;

use App\Models\Event\Event;
use Database\Factories\VenueFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $name
 * @property string $address
 * @property string|null $city
 * @property string|null $country
 * @property string|null $postal_code
 * @property string|null $phone
 * @property string|null $website
 * @property string|null $geolocation
 * @property-read Collection<int, Event> $events
 * @property-read int|null $events_count
 *
 * @method static VenueFactory factory($count = null, $state = [])
 * @method static Builder<static>|Venue newModelQuery()
 * @method static Builder<static>|Venue newQuery()
 * @method static Builder<static>|Venue query()
 * @method static Builder<static>|Venue whereAddress($value)
 * @method static Builder<static>|Venue whereCity($value)
 * @method static Builder<static>|Venue whereCountry($value)
 * @method static Builder<static>|Venue whereCreatedAt($value)
 * @method static Builder<static>|Venue whereGeolocation($value)
 * @method static Builder<static>|Venue whereId($value)
 * @method static Builder<static>|Venue whereName($value)
 * @method static Builder<static>|Venue wherePhone($value)
 * @method static Builder<static>|Venue wherePostalCode($value)
 * @method static Builder<static>|Venue whereUpdatedAt($value)
 * @method static Builder<static>|Venue whereWebsite($value)
 *
 * @mixin Eloquent
 */
class Venue extends Model
{
    /** @use HasFactory<VenueFactory> */
    use HasFactory;

    protected $guarded = [];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }
}
