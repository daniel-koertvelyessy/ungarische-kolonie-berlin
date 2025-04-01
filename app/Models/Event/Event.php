<?php

namespace App\Models\Event;

use App\Enums\EventStatus;
use App\Models\EventAssignment;
use App\Models\EventTimeline;
use App\Models\Traits\HasHistory;
use App\Models\Venue;
use Database\Factories\Event\EventFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @method static Event create(array $attributes)
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $event_date
 * @property Carbon|null $start_time
 * @property Carbon|null $end_time
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
 * @property-read Collection<int, EventAssignment> $assignments
 * @property-read int|null $assignments_count
 * @property-read Collection<int, EventSubscription> $subscriptions
 * @property-read int|null $subscriptions_count
 * @property-read Collection<int, EventTimeline> $timelines
 * @property-read int|null $timelines_count
 * @property-read Venue|null $venue
 * @property-read Collection<int, EventVisitor> $visitors
 * @property-read int|null $visitors_count
 *
 * @method static EventFactory factory($count = null, $state = [])
 * @method static Builder<static>|Event newModelQuery()
 * @method static Builder<static>|Event newQuery()
 * @method static Builder<static>|Event query()
 * @method static Builder<static>|Event whereCreatedAt($value)
 * @method static Builder<static>|Event whereDescription($value)
 * @method static Builder<static>|Event whereEndTime($value)
 * @method static Builder<static>|Event whereEntryFee($value)
 * @method static Builder<static>|Event whereEntryFeeDiscounted($value)
 * @method static Builder<static>|Event whereEventDate($value)
 * @method static Builder<static>|Event whereExcerpt($value)
 * @method static Builder<static>|Event whereId($value)
 * @method static Builder<static>|Event whereImage($value)
 * @method static Builder<static>|Event whereName($value)
 * @method static Builder<static>|Event wherePaymentLink($value)
 * @method static Builder<static>|Event whereSlug($value)
 * @method static Builder<static>|Event whereStartTime($value)
 * @method static Builder<static>|Event whereStatus($value)
 * @method static Builder<static>|Event whereTitle($value)
 * @method static Builder<static>|Event whereUpdatedAt($value)
 * @method static Builder<static>|Event whereVenueId($value)
 *
 * @mixin Eloquent
 */
class Event extends Model
{
    use HasFactory;
    use HasHistory;

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
        'name' => 'string',
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

    public function posts(): hasMany
    {
        return $this->hasMany(\App\Models\Blog\Post::class);
    }

    public function relatedPosts(): \Illuminate\Support\Collection
    {
        return $this->posts()->where('status', EventStatus::PUBLISHED->value)->get();
    }
}
