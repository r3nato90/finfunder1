<?php

namespace App\Http\Controllers\Api\User;

use App\Enums\CommissionType;
use App\Http\Controllers\Controller;
use App\Http\Requests\EnrollMatrixRequest;
use App\Http\Resources\CommissionResource;
use App\Http\Resources\InvestmentUserRewardResource;
use App\Http\Resources\MatrixPlanResource;
use App\Models\InvestmentUserReward;
use App\Services\Investment\CommissionService;
use App\Services\Investment\MatrixInvestmentService;
use App\Services\Investment\MatrixService;
use App\Services\SettingService;
use App\Services\UserService;
use App\Utilities\Api\ApiJsonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MatrixController extends Controller
{
    public function __construct(
        protected MatrixService $matrixService,
        protected MatrixInvestmentService $matrixInvestmentService,
        protected CommissionService $commissionService,
        protected UserService $userService
    )
    {

    }

    public function index(): JsonResponse
    {
        $userId = (int)Auth::id();
        $referral = $this->commissionService->getCommissionsOfType(CommissionType::REFERRAL, with: ['fromUser'], userId: $userId);
        $level = $this->commissionService->getCommissionsOfType(CommissionType::LEVEL, with: ['fromUser'], userId: $userId);

        return ApiJsonResponse::success('Matrix fetched data', [
            'plans' => MatrixPlanResource::collection($this->matrixService->getActivePlan()),
            'matrix_log' => $this->matrixInvestmentService->findByUserId($userId),
            'referral_commissions' => CommissionResource::collection($referral),
            'level_commissions' => CommissionResource::collection($level),
            'referral_commissions_meta' => paginateMeta($referral),
            'level_commissions_meta' => paginateMeta($level),
        ]);
    }


    /**
     * @param EnrollMatrixRequest $request
     * @return JsonResponse
     */
    public function store(EnrollMatrixRequest $request): JsonResponse
    {
        try{
            $user = $this->userService->findById((int)Auth::id());
            $plan = $this->matrixService->findByUid($request->input('uid'));
            $this->matrixInvestmentService->executeEnrolledScheme($request, $plan, $user);
        }catch (\Exception $exception){
            return ApiJsonResponse::error($exception->getMessage());
        }

        return ApiJsonResponse::success("The Matrix scheme has been enrolled.");
    }



    public function investmentReward(): JsonResponse
    {
        $id = Auth::user()->reward_identifier;
        $reward = InvestmentUserReward::find($id);
        $title = "Investment Reward Badges & Level: " . ($reward ? $reward->level : 'N/A');
        $setting = SettingService::getSetting();

        if (getArrayValue($setting->system_configuration, 'investment_reward.value') != \App\Enums\Status::ACTIVE->value) {
            abort(404);
        }

        $investmentUserRewards = InvestmentUserReward::where('status', \App\Enums\Status::ACTIVE->value)->get();
        return ApiJsonResponse::success('Investment reward title', [
            'title' => $title,
            'investmentUserRewards' => InvestmentUserRewardResource::collection($investmentUserRewards),
        ]);
    }
}
