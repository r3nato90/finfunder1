<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\InvestmentUserReward;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvestmentUserRewardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rewards = [
            [
                'name' => 'Bronze Starter',
                'level' => 'Level-1',
                'invest' => 1000,
                'team_invest' => 5000,
                'deposit' => 200,
                'referral_count' => 10,
                'reward' => 100,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Silver Investor',
                'level' => 'Level-2',
                'invest' => 2000,
                'team_invest' => 10000,
                'deposit' => 400,
                'referral_count' => 20,
                'reward' => 200,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Gold Partner',
                'level' => 'Level-3',
                'invest' => 3000,
                'team_invest' => 15000,
                'deposit' => 600,
                'referral_count' => 30,
                'reward' => 300,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Platinum Sponsor',
                'level' => 'Level-4',
                'invest' => 4000,
                'team_invest' => 20000,
                'deposit' => 800,
                'referral_count' => 40,
                'reward' => 400,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Diamond Elite',
                'level' => 'Level-5',
                'invest' => 5000,
                'team_invest' => 25000,
                'deposit' => 1000,
                'referral_count' => 50,
                'reward' => 500,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Ruby Champion',
                'level' => 'Level-6',
                'invest' => 6000,
                'team_invest' => 30000,
                'deposit' => 1200,
                'referral_count' => 60,
                'reward' => 600,
                'status' => Status::ACTIVE->value,
            ],
            [
                'name' => 'Sapphire Master',
                'level' => 'Level-7',
                'invest' => 7000,
                'team_invest' => 35000,
                'deposit' => 1400,
                'referral_count' => 70,
                'reward' => 700,
                'status' => Status::ACTIVE->value,
            ],
        ];

        foreach ($rewards as $reward) {
            InvestmentUserReward::create($reward);
        }
    }
}
