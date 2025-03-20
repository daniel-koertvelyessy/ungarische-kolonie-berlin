<?php

namespace Database\Factories\Event;

use App\Models\Event\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event\EventSubscription>
 */
class EventSubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'                => fake()->name,
            'email'               => fake()->email,
            'phone'               => fake()->phoneNumber,
            'remarks'             => fake()->realText(),
            'consentNotification' => true,
            'event_id'            => Event::factory()->create()->id,
            'confirmed_at'        => null
        ];
    }
}
