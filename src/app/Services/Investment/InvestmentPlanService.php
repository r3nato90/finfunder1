<?php

namespace App\Services\Investment;

use App\Enums\Matrix\PlanStatus;
use App\Models\InvestmentPlan;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Str;

class InvestmentPlanService
{
    /**
     * @return AbstractPaginator
     */
    public function getBinaryOptionPlanByPaginate(): AbstractPaginator
    {
        return InvestmentPlan::latest()->with('timeTable')->paginate(getPaginate());
    }


    /**
     * @param string $uid
     * @return InvestmentPlan|null
     */
    public function findByUid(string $uid): ?InvestmentPlan
    {
        return InvestmentPlan::where('uid', $uid)->first();
    }


    public function prepParams(Request $request): array
    {
        return [
            'uid' => Str::random(),
            'name' => $request->input('name'),
            'minimum' => $request->input('minimum', 0),
            'maximum' => $request->input('maximum', 0),
            'amount' => $request->input('amount', 0),
            'interest_rate' => $request->input('interest_rate'),
            'duration' => $request->input('repeat_time', 0),
            'meta' => $request->input('features'),
            'terms_policy' => $request->input('terms_policy'),
            'type' => $request->input('type'),
            'is_recommend' => $request->boolean('is_recommend'),
            'status' => $request->input('status'),
            'interest_type' => $request->input('interest_type'),
            'time_id' => $request->input('time_id'),
            'interest_return_type' => $request->input('interest_return_type'),
            'recapture_type' => $request->input('recapture_type', 0),
        ];
    }


    /**
     * @param array $input
     * @return InvestmentPlan
     */
    public function save(array $input): InvestmentPlan
    {
        return InvestmentPlan::create($input);
    }


    public function getActivePlan(array $with = [], int $userId = null): Collection
    {
        $query =  InvestmentPlan::query();

        if(!empty($with)){
            $query->with($with);
        }

        $query->where('status', PlanStatus::ENABLE->value)
            ->whereHas('investmentLogs', function ($query) use ($userId) {
                $query->where('status', '!=', \App\Enums\Investment\Status::CANCELLED)
                    ->when($userId !== null, function ($query) use ($userId) {
                        $query->where('user_id', $userId);
                    });
                });


        return $query->get();
    }

    public function fetchActivePlan(): Collection
    {
        return InvestmentPlan::query()->where('status', PlanStatus::ENABLE->value)->get();
    }


    /**
     * @param Request $request
     * @return InvestmentPlan
     */
    public function update(Request $request): InvestmentPlan
    {
        $binaryOption = $this->findByUid($request->input('uid'));
        $binaryOption->update($this->prepParams($request));

        return $binaryOption;
    }

}
