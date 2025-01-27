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
        $start = now()->addMonths($inter);
        $end = now()->addMonths($inter)->addHours(rand(2,8));
        return [
            'starts_at' => $start,
            'ends_at' => $end,
            'slug' => [
                'de'=>fake()->unique()->slug(),
                'hu'=>fake()->unique()->slug(),
            ],
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
