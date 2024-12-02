<?php

namespace App\Services\Investment;

use App\Enums\Matrix\PlanStatus;
use App\Models\Matrix;
use App\Models\MatrixLevel;
use App\Services\SettingService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class MatrixService
{
    /**
     * @param array $with
     * @return AbstractPaginator
     */
    public function getPlansByPaginate(array $with = []): AbstractPaginator
    {
        return Matrix::with($with)->orderBy('id')->paginate(getPaginate());
    }


    /**
     * @param string $uid
     * @return Matrix|null
     */
    public function findByUid(string $uid): ?Matrix
    {
        return Matrix::where('uid', $uid)->first();
    }


    /**
     * @param Request $request
     * @return array
     */
    public function prepParams(Request $request): array
    {
        return [
            'uid' => Str::random(),
            'name' => $request->input('name'),
            'amount' => $request->input('amount'),
            'referral_reward' =>  $request->input('referral_reward'),
            'is_recommend' =>  $request->boolean('is_recommend'),
            'status' => $request->input('status')
        ];
    }

    /**
     * @param array $params
     * @return Matrix
     */
    public function save(array $params): Matrix
    {
        return Matrix::create($params);
    }


    /**
     * @param array $matrix_levels
     * @param int $planId
     * @return void
     */
    public function updatePlanMatrixLevels(array $matrix_levels, int $planId): void
    {
        MatrixLevel::where('plan_id', $planId)->delete();

        foreach($matrix_levels as $level => $amount){
            MatrixLevel::create([
                'plan_id' => $planId,
                'level' => $level,
                'amount' => $amount
            ]);
        }
    }

    /**
     * @param array $with
     * @return Collection|array
     */
    public function getActivePlan(array $with = []): Collection|array
    {
        return Matrix::with($with)
            ->where('status', PlanStatus::ENABLE->value)
            ->orderBy('id')
            ->get();
    }


    public static function calculateTotalLevel(int $id)
    {
        return MatrixLevel::where('plan_id',  $id)
            ->where('level', '<=', self::getMatrixHeight())
            ->get();
    }

    /**
     * @return int
     */
    public static function getMatrixHeight(): int
    {
        $settings = SettingService::getSetting();
        return (int)Arr::get($settings->matrix_parameters, 'height');
    }

    /**
     * @return int
     */
    public static function getMatrixWidth(): int
    {
        $settings = SettingService::getSetting();
        return (int)Arr::get($settings->matrix_parameters, 'width');
    }

    /**
     * @param int $id
     * @return float|int
     */
    public static function calculateAggregateCommission(int $id): float|int
    {
        $aggregateCommission = 0;

        $iteration = 1;
        foreach (self::calculateTotalLevel($id) as $key => $value) {
            $matrixCalculation = pow(self::getMatrixWidth(), $iteration);
            $aggregateCommission += $value->amount * $matrixCalculation;
            $iteration++;
        }

        return $aggregateCommission;
    }
}
