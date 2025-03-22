<?php

namespace Database\Factories\Accounting;

use App\Enums\ReportStatus;
use App\Models\Accounting\Account;
use App\Models\Accounting\AccountReport;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AccountReport>
 */
class AccountReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = $this->faker->date();

        $start = Carbon::createFromDate($date);
        $end = Carbon::createFromDate($date)->addMonths($this->faker->numberBetween(1, 3));

        return [
            'starting_amount' => fake()->randomNumber(),
            'end_amount' => fake()->randomNumber(),
            'total_income' => fake()->randomNumber(),
            'total_expenditure' => fake()->randomNumber(),
            'period_start' => $start,
            'period_end' => $end,
            'account_id' => Account::factory()->create()->id,
            'created_by' => fake()->randomElement(User::all()->pluck('id')->toArray()),
            'status' => fake()->randomElement(ReportStatus::toArray()),
        ];
    }
}
