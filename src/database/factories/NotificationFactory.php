<?php

namespace Database\Factories;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $notifiable = User::inRandomOrder()->first();

        return [
            'id' => $this->faker->uuid,
            'type' => $this->faker->word,
            'notifiable_type' => User::class,
            'notifiable_id' => $notifiable->id,
            'data' => [
                'message' => $this->faker->sentence,
                'url' => route('admin.withdraw.details', $notifiable->id),
            ],
            'read_at' => $this->faker->boolean ? now() : null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
