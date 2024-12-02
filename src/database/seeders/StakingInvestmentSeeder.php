<?php

namespace Database\Seeders;

use App\Models\StakingPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StakingInvestmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stakingPlans = [
            [
                'duration'=> 15,
                'interest_rate' => 10,
                'minimum_amount' => 100,
                'maximum_amount' =>1000,
                'status' =>1
            ],
            [
                'duration'=> 30,
                'interest_rate' => 15,
                'minimum_amount' => 1000,
                'maximum_amount' =>10000,
                'status' =>1
            ],
            [
                'duration'=> 45,
                'interest_rate' => 20,
                'minimum_amount' => 10000,
                'maximum_amount' =>100000,
                'status' =>1
            ],
            [
                'duration'=> 60,
                'interest_rate' => 15,
                'minimum_amount' => 100000,
                'maximum_amount' =>1000000,
                'status' =>1
            ],
            [
                'duration'=> 75,
                'interest_rate' => 25,
                'minimum_amount' => 10000,
                'maximum_amount' =>100000,
                'status' => 1
            ],
            [
                'duration'=> 90,
                'interest_rate' => 30,
                'minimum_amount' => 100000,
                'maximum_amount' =>1000000,
                'status' => 1
            ],
        ];

        StakingPlan::truncate();
        collect($stakingPlans)->each(fn($stakingPlan) => StakingPlan::create($stakingPlan));
    }
}
