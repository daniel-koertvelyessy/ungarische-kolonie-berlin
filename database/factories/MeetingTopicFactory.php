<?php

namespace Database\Factories;

use App\Models\MeetingMinute;
use App\Models\MeetingTopic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MeetingTopic>
 */
class MeetingTopicFactory extends Factory
{
    protected $model = MeetingTopic::class;

    public function definition()
    {
        return [
            'content' => $this->faker->paragraph(),
            'meeting_id' => MeetingMinute::factory(),
        ];
    }
}
