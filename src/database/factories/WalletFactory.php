<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Wallet>
 */
class WalletFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();
        return [
            'user_id' => $user->id,
            'primary_balance' => 0,
            'investment_balance' => 0,
            'trade_balance' => 0,
            'practice_balance' => 0,
            'created_at' =>  now(),
            'updated_at' => now(),
        ];
    }
}
