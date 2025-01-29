<?php

namespace Database\Factories;

use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $inter = fake()->numberBetween(0,5);

        $start = now()->addHours($inter);
        $end = now()->addHours($inter)->addHours(rand(2,8));

        $fee = fake()->randomNumber(2);
        $disc_fee = round($fee * 0.7,0);

        return [
            'event_date' => now()->addMonths($inter)->format('Y-m-d'),
            'start_time' => $start->format('H:i'),
            'end_time' => $end->format('H:i'),
            'slug' => [
                'de'=>fake()->unique()->slug(),
                'hu'=>fake()->unique()->slug(),
            ],
            'entry_fee' => $fee,
            'entry_fee_discounted' => $disc_fee,
            'title' => [
                'de'=>fake()->sentence(),
                'hu'=>fake()->sentence(),
            ],
            'description' => [
                'de'=>fake()->sentences(4,true),
                'hu'=>fake()->sentences(4, true),
            ],
            'venue_id' => Venue::factory()->create(),
        ];
    }
}
