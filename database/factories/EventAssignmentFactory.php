<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\AssignmentStatus;
use App\Models\Event\Event;
use App\Models\EventAssignment;
use App\Models\Membership\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EventAssignment>
 */
final class EventAssignmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = \App\Models\User::factory()->create();
        $member = Member::factory()->create(['user_id' => $user->id]);

        return [
            'task' => fake()->text(),
            'status' => fake()->randomElement(AssignmentStatus::toArray()),
            'event_id' => Event::factory()->create()->id,
            'member_id' => $member->id,
            'user_id' => $user->id,
        ];
    }
}
