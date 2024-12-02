<?php

namespace Database\Factories;

use App\Enums\Investment\Status;
use App\Models\InvestmentLog;
use App\Models\InvestmentPlan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InvestmentLog>
 */
class InvestmentLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userId = User::inRandomOrder()->first()->id;
        $investmentPlanId = InvestmentPlan::inRandomOrder()->first()->id;

        return [
            'user_id' => $userId,
            'uid' => $this->faker->unique()->regexify('[A-Za-z0-9]{16}'),
            'investment_plan_id' => $investmentPlanId,
            'plan_name' => $this->faker->word,
            'trx' => getTrx(),
            'amount' => $this->faker->randomFloat(8, 0, 1000),
            'profit' => $this->faker->randomFloat(8, 0, 100),
            'daily_profit' => $this->faker->randomFloat(8, 0, 100),
            'interest_rate' => $this->faker->randomFloat(8, 0, 1),
            'expiration_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'profit_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'is_reinvest' => $this->faker->boolean,
            'status' => $this->faker->randomElement([
                Status::INITIATED->value,
                Status::PROFIT_COMPLETED->value,
                Status::COMPLETED->value,
                Status::CANCELLED->value,
            ]),
            'created_at' =>  $this->faker->dateTimeBetween('-12 months', 'now'),
            'updated_at' => now(),
        ];
    }
}
