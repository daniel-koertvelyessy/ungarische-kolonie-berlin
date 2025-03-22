<?php

namespace Database\Factories\Accounting;

use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Models\Accounting\Account;
use App\Models\Accounting\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amount_gross = $this->faker->randomNumber(2) * 100;
        $vat = 19;
        $amount_net = $amount_gross * (100 - $vat) / 100;

        return [
            'date' => fake()->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'label' => fake()->slug,
            'amount_gross' => Account::makeCentInteger($amount_gross),
            'vat' => $vat,
            'amount_net' => Account::makeCentInteger($amount_net),
            'account_id' => Account::factory()->create()->id, // $this->faker->randomElement(Account::all()->pluck('id')->toArray()),
            'type' => $this->faker->randomElement([TransactionType::Withdrawal, TransactionType::Deposit]),
            'status' => TransactionStatus::booked->value,
        ];
    }
}
