<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    /** @use HasFactory<\Database\Factories\AttendeeFactory> */
    use HasFactory;

    protected $table = 'attendees';

    protected $guarded = [];

    public function meetingMinute()
    {
        return $this->belongsTo(MeetingMinute::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class); // Optional, if tied to a User model
    }
}
