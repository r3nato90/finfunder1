<?php

namespace Database\Seeders;

use App\Enums\Investment\InterestType;
use App\Enums\Investment\InvestmentRage;
use App\Enums\Investment\Recapture;
use App\Enums\Investment\ReturnType;
use App\Enums\Matrix\PlanStatus;
use App\Models\InvestmentPlan;
use App\Models\TimeTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InvestmentPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $investmentPlans = [
            [
                'uid' => Str::random(),
                'name' => 'Starter',
                'amount' => 1000,
                'interest_rate' => 2,
                'duration' => 15,
                'meta' => [
                    'Ideal for Beginners',
                    'Low-Risk Introduction',
                    'Quick Return Period',
                ],
                'terms_policy' => 'Terms and policies for the Starter plan.',
                'is_recommend' => true,
                'type' => InvestmentRage::FIXED->value,
                'status' => PlanStatus::ENABLE->value,
                'interest_type' => InterestType::PERCENT->value,
                'time_id' => TimeTable::inRandomOrder()->first()->id,
                'interest_return_type' => ReturnType::REPEAT->value,
                'recapture_type' => Recapture::NO->value,
            ],
            [
                'uid' => Str::random(),
                'name' => 'Growth',
                'minimum' => 2000,
                'maximum' => 5000,
                'interest_rate' => 3.5,
                'duration' => 45,
                'meta' => [
                    'Accelerated Earnings',
                    'Medium-Term Growth',
                    'For Experienced Investors',
                ],
                'terms_policy' => 'Terms and policies for the Growth plan.',
                'is_recommend' => false,
                'type' => InvestmentRage::RANGE->value,
                'status' => PlanStatus::ENABLE->value,
                'interest_type' => InterestType::FIXED->value,
                'time_id' => TimeTable::inRandomOrder()->first()->id,
                'interest_return_type' => ReturnType::REPEAT->value,
                'recapture_type' =>  Recapture::YES->value,
            ],
            [
                'uid' => Str::random(),
                'name' => 'Advanced',
                'minimum' => 6000,
                'maximum' => 20000,
                'interest_rate' => 4.5,
                'duration' => 60,
                'meta' => [
                    'High Returns for Experts',
                    'Long-Term Investment',
                    'Substantial Capital Growth',
                ],
                'terms_policy' => 'Terms and policies for the Advanced plan.',
                'is_recommend' => true,
                'type' => InvestmentRage::RANGE->value,
                'status' => PlanStatus::ENABLE->value,
                'interest_type' => InterestType::PERCENT->value,
                'time_id' => TimeTable::inRandomOrder()->first()->id,
                'interest_return_type' => ReturnType::REPEAT->value,
                'recapture_type' => Recapture::YES->value,
            ],
            [
                'uid' => Str::random(),
                'name' => 'Balanced',
                'minimum' => 1000,
                'maximum' => 3000,
                'interest_rate' => 3,
                'duration' => 30,
                'meta' => [
                    'Stable Growth',
                    'Moderate Risk and Return',
                    'Ideal for Conservative Investors',
                ],
                'terms_policy' => 'Terms and policies for the Balanced plan.',
                'is_recommend' => false,
                'type' => InvestmentRage::RANGE->value,
                'status' => PlanStatus::ENABLE->value,
                'interest_type' => InterestType::FIXED->value,
                'time_id' => TimeTable::inRandomOrder()->first()->id,
                'interest_return_type' => ReturnType::REPEAT->value,
                'recapture_type' => Recapture::NO->value,
            ],
            [
                'uid' => Str::random(),
                'name' => 'Flexi',
                'minimum' => 500,
                'maximum' => 2500,
                'interest_rate' => 2.5,
                'duration' => 20,
                'meta' => [
                    'Flexible Terms',
                    'Quick Access to Funds',
                    'Lower Risk Profile',
                ],
                'terms_policy' => 'Terms and policies for the Flexi plan.',
                'is_recommend' => true,
                'type' => InvestmentRage::RANGE->value,
                'status' => PlanStatus::ENABLE->value,
                'interest_type' => InterestType::PERCENT->value,
                'time_id' => TimeTable::inRandomOrder()->first()->id,
                'interest_return_type' => ReturnType::REPEAT->value,
                'recapture_type' => Recapture::YES->value,
            ],
            [
                'uid' => Str::random(),
                'name' => 'Premium',
                'minimum' => 10000,
                'maximum' => 50000,
                'interest_rate' => 5,
                'duration' => null,
                'meta' => [
                    'Highest Return Rates',
                    'Longest Investment Period',
                    'Exclusive for High Stake Investors',
                ],
                'terms_policy' => 'Terms and policies for the Premium plan.',
                'is_recommend' => false,
                'type' => InvestmentRage::RANGE->value,
                'status' => PlanStatus::ENABLE->value,
                'interest_type' => InterestType::FIXED->value,
                'time_id' => TimeTable::inRandomOrder()->first()->id,
                'interest_return_type' => ReturnType::LIFETIME->value,
                'recapture_type' => Recapture::YES->value,
            ],
        ];

        InvestmentPlan::truncate();
        collect($investmentPlans)->each(fn($investmentPlan) => InvestmentPlan::create($investmentPlan));

    }
}
