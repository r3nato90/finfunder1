<?php

namespace Database\Factories;

use App\Enums\Transaction\Source;
use App\Enums\Transaction\Type;
use App\Enums\Transaction\WalletType;
use App\Models\Transaction;
use App\Models\User;
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
        // Get a random user ID from the existing users in the database
        $userId = User::inRandomOrder()->first()->id;

        return [
            'user_id' => $userId,
            'amount' => $this->faker->randomFloat(8, 1, 1000),
            'post_balance' => $this->faker->randomFloat(8, 1, 1000),
            'charge' => $this->faker->randomFloat(8, 0, 100),
            'trx' => getTrx(),
            'type' => $this->faker->randomElement([Type::PLUS->value, Type::MINUS->value]),
            'wallet_type' => $this->faker->randomElement([
                WalletType::PRIMARY->value,
                WalletType::INVESTMENT->value,
                WalletType::TRADE->value,
            ]),
            'source' => $this->faker->randomElement([
                Source::ALL->value,
                Source::MATRIX->value,
                Source::INVESTMENT->value,
                Source::TRADE->value,
            ]),
            'details' => $this->faker->sentence,
            'created_at' =>  $this->faker->dateTimeBetween('-12 months', 'now'),
            'updated_at' => now(),
        ];
    }
}
