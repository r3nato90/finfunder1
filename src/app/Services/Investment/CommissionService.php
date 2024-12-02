<?php

namespace App\Services\Investment;

use App\Enums\CommissionType;
use App\Models\Commission;
use Illuminate\Pagination\AbstractPaginator;

class CommissionService
{

    /**
     * @param int|string $userId
     * @param string $details
     * @param CommissionType $commissionType
     * @param int|float|string $amount
     * @param int|string|null $fromUserId
     * @param null $investmentLogId
     * @return array
     */
    public function prepParams(int|string $userId, string $details, CommissionType $commissionType, int|float|string $amount, int|string $fromUserId = null, $investmentLogId = null): array
    {
        return [
            'user_id' => $userId,
            'from_user_id' => $fromUserId,
            'amount' => $amount,
            'trx' => getTrx(),
            'type' => $commissionType->value,
            'investment_log_id' => $investmentLogId,
            'details' => $details,
        ];
    }

    /**
     * @param array $params
     * @return Commission
     */
    public function save(array $params): Commission
    {
        return Commission::create($params);
    }


    /**
     *
     * @param CommissionType $commissionType
     * @param array $with
     * @param int|string|null $userId
     * @param int|string|null $investmentLogId
     * @return AbstractPaginator
     */
    public function getCommissionsOfType(CommissionType $commissionType, array $with = [], int|string $userId = null, int|string $investmentLogId = null): AbstractPaginator
    {
        return Commission::filter(request()->all())
            ->where('type', $commissionType->value)
            ->when(!is_null($userId), fn ($query) => $query->where('user_id', $userId))
            ->when(!is_null($investmentLogId), fn ($query) => $query->where('investment_log_id', $investmentLogId))
            ->when(!empty($with), fn ($query) => $query->with($with))
            ->orderByDesc('id')
            ->paginate(getPaginate());
    }



    public function getCommissionsSum(int $userId): array
    {
        return [
            'referral' => Commission::where('user_id', $userId)->where('type', CommissionType::REFERRAL->value)->sum('amount'),
            'investment' => Commission::where('user_id', $userId)->where('type', CommissionType::INVESTMENT->value)->sum('amount'),
            'level' => Commission::where('user_id', $userId)->where('type', CommissionType::LEVEL->value)->sum('amount'),
            'deposit' => Commission::where('user_id', $userId)->where('type', CommissionType::DEPOSIT->value)->sum('amount'),
        ];
    }

}
