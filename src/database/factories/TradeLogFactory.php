<?php

namespace Database\Factories;

use App\Enums\Trade\TradeOutcome;
use App\Enums\Trade\TradeStatus;
use App\Enums\Trade\TradeType;
use App\Enums\Trade\TradeVolume;
use App\Models\CryptoCurrency;
use App\Models\TradeLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TradeLog>
 */
class TradeLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userId = User::inRandomOrder()->first()->id;
        $cryptoCurrencyId = CryptoCurrency::inRandomOrder()->first()->id;

        return [
            'user_id' => $userId,
            'crypto_currency_id' => $cryptoCurrencyId,
            'original_price' => $this->faker->randomFloat(8, 0, 1000),
            'amount' => $this->faker->randomFloat(8, 0, 1000),
            'duration' => $this->faker->numberBetween(1, 30), // Adjust as needed
            'arrival_time' => $this->faker->dateTimeBetween('now', '+1 year'),
            'type' => $this->faker->randomElement([
                TradeType::TRADE->value,
                TradeType::PRACTICE->value,
            ]),
            'volume' => $this->faker->randomElement([
                TradeVolume::HIGH->value,
                TradeVolume::LOW->value,
            ]),
            'outcome' => $this->faker->randomElement([
                TradeOutcome::WIN->value,
                TradeOutcome::LOSE->value,
                TradeOutcome::DRAW->value,
            ]),
            'status' => $this->faker->randomElement([
                TradeStatus::RUNNING->value,
                TradeStatus::COMPLETE->value,
            ]),
            'meta' => ['key' => 'value'],
            'created_at' =>  $this->faker->dateTimeBetween('-12 months', 'now'),
            'updated_at' => now(),
        ];
    }
}
