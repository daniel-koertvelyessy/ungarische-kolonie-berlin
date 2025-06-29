<?php

declare(strict_types=1);

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
            'date' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d'), // date
            'label' => fake()->slug, // label
            'amount_gross' => Account::makeCentInteger($amount_gross), // amount_gross
            'vat' => $vat, // vat
            'amount_net' => Account::makeCentInteger($amount_net), // amount_net
            'account_id' => Account::factory()->create()->id, // $this->faker->randomElement(Account::all()->pluck('id')->toArray()), // Account
            'type' => $this->faker->randomElement([TransactionType::Withdrawal, TransactionType::Deposit]), // type
            'status' => TransactionStatus::booked->value, // status
        ];
    }
}
