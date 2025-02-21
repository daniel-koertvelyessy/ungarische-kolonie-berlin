<?php

namespace App\Models\Event;

use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

    protected $fillable = [
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
