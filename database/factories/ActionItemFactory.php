<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ActionItem;
use App\Models\MeetingMinute;
use App\Models\MeetingTopic;
use App\Models\Membership\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ActionItem>
 */
final class ActionItemFactory extends Factory
{
    protected $model = ActionItem::class;

    public function definition()
    {
        return [
            'meeting_minute_id' => MeetingMinute::factory(),
            'meeting_topic_id' => MeetingTopic::factory(),
            'description' => $this->faker->sentence(),
            'assignee_id' => Member::factory(),
            'due_date' => $this->faker->dateTimeThisMonth(),
            'completed' => false,
        ];
    }
}
