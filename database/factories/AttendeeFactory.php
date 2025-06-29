<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Attendee;
use App\Models\MeetingMinute;
use App\Models\Membership\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendee>
 */
class AttendeeFactory extends Factory
{
    protected $model = Attendee::class;

    public function definition()
    {
        return [
            'meeting_minute_id' => MeetingMinute::factory(),
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'member_id' => Member::factory(),
        ];
    }
}
