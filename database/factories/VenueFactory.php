<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Venue>
 */
class VenueFactory extends Factory
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
            'address' => fake()->streetAddress,
            'city' => fake()->city,
            'country' => fake()->country,
            'postal_code' => fake()->postcode,
            'phone' => fake()->phoneNumber,
            'website' => fake()->domainName,
            'geolocation' => null,
        ];
    }
}
