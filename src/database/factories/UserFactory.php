<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Enums\User\KycStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'uuid' => Str::uuid(),
            'referral_by' => null,
            'position_id' => null,
            'position' => null,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->unique()->phoneNumber,
            'email_verified_at' => now(),
            'image' => null,
            'kyc_status' => KycStatus::ACTIVE->value,
            'status' => Status::ACTIVE->value,
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'meta' => null,
        ];
    }
}
