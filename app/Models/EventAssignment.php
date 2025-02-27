<?php

namespace App\Models;

use App\Enums\AssignmentStatus;
use App\Models\Event\Event;
use App\Models\Membership\Member;
use Database\Factories\EventAssignmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

/**
 * @method static EventAssignment create(array $attributes)
 *
 */
class EventAssignment extends Model
{
    /** @use HasFactory<EventAssignmentFactory> */
    use HasFactory, Notifiable;


    protected $guarded = [];

    protected $casts = [
        'due_at' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function statusColor():string
    {
        return AssignmentStatus::color($this->status);
    }

    public function statusLabel():string
    {
        return AssignmentStatus::value($this->status);
    }

    public function getDueString():string
    {
        return $this->due_at->isPast() ? $this->due_at->format('Y-m-d') : $this->due_at->diffForHumans();

    }

    public function amountString():string
    {
        return $this->amount
        ? number_format($this->amount/100,2,',','.') . ' EUR'
            :'-,--';
    }


}
