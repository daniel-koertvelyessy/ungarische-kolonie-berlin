<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MeetingMinute extends Model
{
    /** @use HasFactory<\Database\Factories\MeetingMinuteFactory> */
    use HasFactory;

    protected $table = 'meeting_minutes';

    protected $guarded = [];

    public function attendees(): HasMany
    {
        return $this->hasMany(Attendee::class);
    }

    public function actionItems(): HasMany
    {
        return $this->hasMany(ActionItem::class);
    }
}
