<?php

namespace Database\Factories;

use App\Enums\Payment\Withdraw\Status;
use App\Models\User;
use App\Models\WithdrawMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WithdrawLog>
 */
class WithdrawLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userId = User::inRandomOrder()->first()->id;
        $withdrawMethodId = WithdrawMethod::inRandomOrder()->first()->id;

        return [
            'uid' => $this->faker->uuid,
            'withdraw_method_id' => $withdrawMethodId,
            'user_id' => $userId,
            'currency' => $this->faker->currencyCode,
            'rate' => $this->faker->randomFloat(8, 0, 1),
            'amount' => $this->faker->randomFloat(8, 0, 1000),
            'charge' => $this->faker->randomFloat(8, 0, 100),
            'final_amount' => $this->faker->randomFloat(8, 0, 1000),
            'after_charge' => $this->faker->randomFloat(8, 0, 1000),
            'trx' => getTrx(),
            'meta' => ['key' => 'value'],
            'details' => $this->faker->text,
            'status' => $this->faker->randomElement([
                Status::SUCCESS->value,
                Status::PENDING->value,
                Status::CANCEL->value,
            ]),
            'created_at' => $this->faker->dateTimeBetween('-12 months', 'now'),
            'updated_at' => now(),
        ];
    }
}
