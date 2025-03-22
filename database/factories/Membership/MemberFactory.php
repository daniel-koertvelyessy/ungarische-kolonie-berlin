<?php

namespace Database\Factories\Membership;

use App\Enums\Gender;
use App\Enums\MemberType;
use App\Models\Membership\Member;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    protected $model = Member::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $gen = Gender::ma->value;

        return [
            'applied_at' => fake()->dateTimeBetween('-55 years', 'now')->format('Y-m-d'),
            'entered_at' => fake()->dateTimeBetween('-55 years', 'now')->format('Y-m-d'),
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
            'type' => MemberType::ST->value,
            'user_id' => User::factory()->create()->id,

        ];
    }
}
