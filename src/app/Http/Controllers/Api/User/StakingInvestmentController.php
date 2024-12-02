<?php

namespace App\Http\Controllers\Api\User;

use App\Enums\Transaction\WalletType;
use App\Http\Controllers\Controller;
use App\Http\Requests\StakingInvestmentRequest;
use App\Http\Resources\StakingInvestmentResource;
use App\Http\Resources\StakingPlanResource;
use App\Services\Investment\Staking\PlanService;
use App\Services\Investment\Staking\StakingInvestmentService;
use App\Services\Payment\WalletService;
use App\Utilities\Api\ApiJsonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class StakingInvestmentController extends Controller
{
    public function __construct(
        protected PlanService $planService,
        protected WalletService $walletService,
        protected StakingInvestmentService $investmentService,
    )
    {

    }

    public function index(): JsonResponse
    {
        $stakingInvestments = $this->investmentService->getPaginate();
        return ApiJsonResponse::success("Staking Investment fetched successfully", [
            'plans' => StakingPlanResource::collection($this->planService->getActivePlans()),
            'staking_investments' => StakingInvestmentResource::collection($stakingInvestments),
            'staking_investments_meta' => paginateMeta($stakingInvestments),
        ]);
    }

    /**
     * @param StakingInvestmentRequest $request
     * @return JsonResponse
     */
    public function store(StakingInvestmentRequest $request): JsonResponse
    {
        $plan = $this->planService->findById($request->input('plan_id'));
        $wallet = Auth::user()->wallet;
        $account = $this->walletService->findBalanceByWalletType(WalletType::PRIMARY->value, $wallet);

        if($request->input('amount') > Arr::get($account, 'balance')){
            return ApiJsonResponse::error("Your primary account balance is insufficient for this investment.");
        }

        if ($request->input('amount') < $plan->minimum_amount || $request->input('amount') > $plan->maximum_amount) {
            return ApiJsonResponse::error('The investment amount should be between ' . getCurrencySymbol().shortAmount($plan->minimum_amount) . ' and ' . getCurrencySymbol().shortAmount($plan->maximum_amount));
        }

        $this->investmentService->executeInvestment($request, $wallet, $plan);
        return ApiJsonResponse::success("Staking Investment has been added successfully");
    }
}
