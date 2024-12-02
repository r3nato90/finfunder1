<?php

namespace App\Services\Investment;

use App\Models\InvestmentUserReward;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;

class RewardService
{
    /**
     * @return AbstractPaginator
     */
    public function getByPaginate(): AbstractPaginator
    {
        return InvestmentUserReward::paginate(getPaginate());
    }

    /**
     * @param int|string $id
     * @return InvestmentUserReward|null
     */
    public function findById(int|string $id): ?InvestmentUserReward
    {
        return InvestmentUserReward::find($id);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function prepParams(Request $request): array
    {
        return [
            'name' => $request->input('name'),
            'level' => $request->input('level'),
            'invest' => $request->input('invest'),
            'team_invest' => $request->input('team_invest'),
            'deposit' => $request->input('deposit'),
            'referral_count' => $request->input('referral_count'),
            'reward' => $request->input('reward'),
            'status' => $request->input('status'),
        ];
    }

    /**
     * @param array $params
     * @return InvestmentUserReward
     */
    public function save(array $params): InvestmentUserReward
    {
        return InvestmentUserReward::create($params);
    }

    /**
     * @param Request $request
     * @return InvestmentUserReward|null
     */
    public function update(Request $request): ?InvestmentUserReward
    {
        $reward = $this->findById($request->integer('id'));

        if(is_null($reward)){
            return  null;
        }

        $reward->update($this->prepParams($request));
        return $reward;
    }

}
