<?php

namespace Database\Factories;

use App\Models\MeetingMinute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MeetingMinute>
 */
class MeetingMinuteFactory extends Factory
{
    protected $model = MeetingMinute::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'meeting_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'location' => $this->faker->optional()->city(),
        ];
    }
}
