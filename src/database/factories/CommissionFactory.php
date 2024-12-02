<?php

namespace Database\Factories;

use App\Enums\CommissionType;
use App\Models\Commission;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Commission>
 */
class CommissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userId = User::inRandomOrder()->first()->id;
        $fromUserId = User::inRandomOrder()->first()->id;

        return [
            'user_id' => $userId,
            'from_user_id' => $fromUserId,
            'amount' => $this->faker->randomFloat(8, 0, 1000),
            'trx' => $this->faker->uuid,
            'type' =>  $this->faker->randomElement([
                CommissionType::INVESTMENT->value,
                CommissionType::REFERRAL->value,
                CommissionType::LEVEL->value,
            ]),
            'details' => $this->faker->sentence,
            'created_at' => $this->faker->dateTimeBetween('-12 months', 'now'),
            'updated_at' => now(),
        ];
    }
}
