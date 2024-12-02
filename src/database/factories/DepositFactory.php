<?php

namespace Database\Factories;

use App\Enums\Payment\Deposit\Status;
use App\Enums\Transaction\WalletType;
use App\Models\Deposit;
use App\Models\PaymentGateway;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Deposit>
 */
class DepositFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userId = User::inRandomOrder()->first()->id;
        $paymentGatewayId = PaymentGateway::inRandomOrder()->first()->id;

        return [
            'user_id' => $userId,
            'payment_gateway_id' => $paymentGatewayId,
            'rate' => $this->faker->randomFloat(8, 0, 1),
            'amount' => $this->faker->randomFloat(8, 0, 1000),
            'charge' => $this->faker->randomFloat(8, 0, 100),
            'final_amount' => $this->faker->randomFloat(8, 0, 1000),
            'trx' => getTrx(),
            'crypto_meta' => null,
            'meta' => ['key' => 'value'], // Customize as needed
            'wallet_type' => $this->faker->randomElement([
                WalletType::PRIMARY->value,
                WalletType::INVESTMENT->value,
                WalletType::TRADE->value,
            ]),
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
