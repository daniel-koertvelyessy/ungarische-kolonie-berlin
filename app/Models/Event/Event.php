<?php

namespace App\Models\Event;

use App\Models\EventAssignment;
use App\Models\EventTimeline;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static Event create(array $attributes)
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $event_date
 * @property \Illuminate\Support\Carbon|null $start_time
 * @property \Illuminate\Support\Carbon|null $end_time
 * @property array<array-key, mixed> $title
 * @property array<array-key, mixed>|null $slug
 * @property array<array-key, mixed>|null $excerpt
 * @property array<array-key, mixed>|null $description
 * @property string|null $image
 * @property string $status
 * @property int|null $entry_fee
 * @property int|null $entry_fee_discounted
 * @property int|null $venue_id
 * @property string|null $payment_link
 * @property string|null $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, EventAssignment> $assignments
 * @property-read int|null $assignments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Event\EventSubscription> $subscriptions
 * @property-read int|null $subscriptions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, EventTimeline> $timelines
 * @property-read int|null $timelines_count
 * @property-read Venue|null $venue
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Event\EventVisitor> $visitors
 * @property-read int|null $visitors_count
 *
 * @method static \Database\Factories\Event\EventFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereEntryFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereEntryFeeDiscounted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereEventDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event wherePaymentLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereVenueId($value)
 *
 * @mixin \Eloquent
 */
class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
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
        'venue_id',
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

    public function visitors(): HasMany
    {
        return $this->hasMany(EventVisitor::class);
    }

    public function timelines(): HasMany
    {
        return $this->hasMany(EventTimeline::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(EventAssignment::class);
    }

    /**
     * <!-- JSON-LD-Markup generiert von Google Strukturierte Daten: Markup-Hilfe -->
     * <script type="application/ld+json">
     * {
     * "@context": "http://schema.org",
     * "@type": "Event",
     * "name": ": Faschingsparty",
     * "startDate": "2025-02-15T18:00",
     * "location": {
     * "@type": "Place",
     * "name": "Nachbarschaftshaus am Litzensee",
     * "address": {
     * "@type": "PostalAddress",
     * "streetAddress": "Herbartstraße 25 (S-Bahnhof Messe Nord/ZOB)",
     * "addressLocality": "Berlin",
     * "postalCode": "14057"
     * }
     * },
     * "image": "https://magyar-kolonia-berlin.org/storage/images/z21ZcM6SszxMk3wDCsoyZ6VL9pQ5TqfKmk2B1vv5.jpg",
     * "description": "Herzlich laden wir unsere Mitglieder und Freunde zu unserem Faschingsfest ein.</P><P>Üppiges Büfett und Kuchen. Live Musik von György Csányi. Das Volkstanzensemble Berlin Fono wird im Laufe des Abends ebenfalls auftreten.</P><P>Kostüme bitte nicht vergessen, die besten werden prämiert!</P><P>Getränke werden von uns zu fairen Preisen verkauft."
     * }
     * </script>
     */
}
