<?php

namespace Database\Factories;

use App\Enums\Gender;
use App\Enums\MemberType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $gen= Gender::ma;
        return [
            'applied_at' => fake()->dateTimeBetween('-55 years','now')->format('Y-m-d'),
            'entered_at' => fake()->dateTimeBetween('-55 years','now')->format('Y-m-d'),
            'left_at' => null,
            'is_deducted' => false,
            'birth_date' => fake()->dateTimeBetween('-50 years', '-18 years')->format('Y-m-d'),
            'name' => fake()->name($gen),
            'first_name' => fake()->firstName($gen),
            'email' => fake()->safeEmail,
            'phone' => null,
            'mobile' => fake()->phoneNumber,
            'address' => fake()->streetAddress,
            'city' => fake()->city,
            'country' => fake()->country,
            'gender' => $gen,
            'type' => MemberType::ST,
            'user_id' => null,

        ];
    }
}
