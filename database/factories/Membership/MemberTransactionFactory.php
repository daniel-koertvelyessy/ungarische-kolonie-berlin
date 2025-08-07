<?php

declare(strict_types=1);

namespace Database\Factories\Membership;

use App\Models\Accounting\Transaction;
use App\Models\Membership\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MemberTransaction>
 */
final class MemberTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'member_id' => Member::factory()->create()->id,
            'transaction_id' => Transaction::factory()->create()->id,
        ];
    }
}
