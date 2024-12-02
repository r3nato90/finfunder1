<?php

namespace Database\Seeders;

use App\Enums\Matrix\PlanStatus;
use App\Models\Matrix;
use App\Services\Investment\MatrixService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MatrixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(MatrixService $matrixService): void
    {
        $matrixPlans = [
            [
                'uid' => Str::random(),
                'name' => 'Intermediate',
                'amount' => 100,
                'referral_reward' => 2,
                'is_recommend' => false,
                'status' => PlanStatus::ENABLE->value,
                'level' => [
                    1 => "13",
                    2 => "3",
                    3 => "3",
                    4 => "3",
                    5 => "3",
                ]
            ],
            [
                'uid' => Str::random(),
                'name' => 'Advanced',
                'amount' => 200,
                'referral_reward' => 5,
                'is_recommend' => true,
                'status' => PlanStatus::ENABLE->value,
                'level' => [
                    1 => "15",
                    2 => "5",
                    3 => "5",
                    4 => "5",
                    5 => "5",
                ]
            ],
            [
                'uid' => Str::random(),
                'name' => 'Pro',
                'amount' => 300,
                'referral_reward' => 8,
                'is_recommend' => false,
                'status' => PlanStatus::ENABLE->value,
                'level' => [
                    1 => "20",
                    2 => "7",
                    3 => "7",
                    4 => "7",
                    5 => "7",
                ]
            ],
        ];

        Matrix::truncate();

        foreach ($matrixPlans as $matrix){
            $level = $matrix['level'];
            unset($matrix['level']);
            $plan = Matrix::create($matrix);
            $matrixService->updatePlanMatrixLevels(
                $level,
                (int) $plan->id
            );
        }
    }
}
