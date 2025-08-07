<?php

declare(strict_types=1);

namespace Database\Factories\Event;

use App\Models\Event\Event;
use App\Models\Event\EventSubscription;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EventSubscription>
 */
final class EventSubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'email' => fake()->email,
            'phone' => fake()->phoneNumber,
            'remarks' => fake()->realText(),
            'consentNotification' => true,
            'event_id' => Event::factory()->create()->id,
            'confirmed_at' => null,
        ];
    }
}
