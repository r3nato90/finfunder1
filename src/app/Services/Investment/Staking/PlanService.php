<?php

namespace App\Services\Investment\Staking;

use App\Enums\Status;
use App\Models\StakingPlan;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;

class PlanService
{
    /**
     * @return AbstractPaginator
     */
    public function getByPaginate(): AbstractPaginator
    {
        return StakingPlan::latest()->paginate(getPaginate());
    }
    /**
     * @param int|string $id
     * @return StakingPlan|null
     */
    public function findById(int|string $id): ?StakingPlan
    {
        return StakingPlan::find($id);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function prepParams(Request $request): array
    {
        return [
            'duration' => $request->input('duration'),
            'interest_rate' => $request->input('interest_rate'),
            'minimum_amount' => $request->input('minimum_amount'),
            'maximum_amount' => $request->input('maximum_amount'),
        ];
    }

    /**
     * @param array $params
     * @return StakingPlan
     */
    public function save(array $params): StakingPlan
    {
        return StakingPlan::create($params);
    }

    /**
     * @param Request $request
     * @return StakingPlan|null
     */
    public function update(Request $request): ?StakingPlan
    {
        $plan = $this->findById($request->integer('id'));

        if(is_null($plan)){
            return null;
        }

        $plan->update($this->prepParams($request));
        return $plan;
    }


    public function getActivePlans()
    {
        return StakingPlan::where('status', Status::ACTIVE->value)->get();
    }

}
