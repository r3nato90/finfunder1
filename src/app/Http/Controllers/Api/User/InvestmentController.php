<?php

namespace App\Http\Controllers\Api\User;

use App\Enums\CommissionType;
use App\Enums\Investment\InvestmentRage;
use App\Enums\Investment\Status;
use App\Enums\Payment\NotificationType;
use App\Enums\Transaction\WalletType;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvestmentRequest;
use App\Http\Requests\InvestmentReturnRequest;
use App\Http\Requests\ReInvestmentRequest;
use App\Http\Resources\CommissionResource;
use App\Http\Resources\InvestmentPlanResource;
use App\Http\Resources\InvestmentResource;
use App\Notifications\InvestmentLogNotification;
use App\Services\Investment\CommissionService;
use App\Services\Investment\InvestmentPlanService;
use App\Services\Investment\InvestmentService;
use App\Services\Payment\WalletService;
use App\Services\SettingService;
use App\Utilities\Api\ApiJsonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class InvestmentController extends Controller
{
    public function __construct(
        protected InvestmentPlanService $investmentPlanService,
        protected InvestmentService $investmentService,
        protected CommissionService $commissionService,
        protected WalletService $walletService,
    )
    {

    }
    public function index(): JsonResponse
    {
        $userId = Auth::id();
        $profitLogs = $this->commissionService->getCommissionsOfType(CommissionType::INVESTMENT, userId: $userId);
        $statistics =  $this->investmentService->getInvestmentReport($userId);

        return ApiJsonResponse::success('Investment fetched data', [
            'statistics' => [
                "today_invest" => shortAmount($statistics->today_invest),
                "payable" => shortAmount($statistics->payable),
                "total" => shortAmount($statistics->total),
                "running" => shortAmount($statistics->running),
                "profit" => shortAmount($statistics->profit),
                "closed" => shortAmount($statistics->closed),
                "re_invest" => shortAmount($statistics->re_invest),
            ],
            'monthly_report' => $this->investmentService->monthlyReport($userId),
            'profit_logs' => CommissionResource::collection($profitLogs),
            'profit_logs_meta' => paginateMeta($profitLogs),
        ]);
    }

    public function fund(): JsonResponse
    {
        $userId = Auth::id();
        $investmentLogs = $this->investmentService->getInvestmentLogsByPaginate(with: ['plan'], userId: $userId);

        return ApiJsonResponse::success('Investment fund fetched data', [
            'investment_plans' =>  InvestmentPlanResource::collection($this->investmentPlanService->fetchActivePlan()),
            'founds' => InvestmentResource::collection($investmentLogs),
            'founds_meta' => paginateMeta($investmentLogs),
        ]);
    }

    /**
     * @param InvestmentRequest $request
     * @return JsonResponse
     */
    public function store(InvestmentRequest $request): JsonResponse
    {
        $binaryPlan = $this->investmentPlanService->findByUid($request->input('uid'));
        $currentInvestmentLog = $this->investmentService->findCurrentInvestmentLog((int)Auth::id(), (int)$binaryPlan->id, Status::INITIATED);

        if($currentInvestmentLog){
            return ApiJsonResponse::error("You're already enrolled in this plan. Consider investing in a different one.");
        }

        $wallet = Auth::user()->wallet;
        $account = $this->walletService->findBalanceByWalletType(WalletType::PRIMARY->value, $wallet);

        if($request->input('amount') > Arr::get($account, 'balance')){
            return ApiJsonResponse::error("Your primary account balance is insufficient for this investment.");
        }

        if($binaryPlan->type == InvestmentRage::RANGE->value){
            if ($request->input('amount') < $binaryPlan->minimum || $request->input('amount') > $binaryPlan->maximum) {
                return ApiJsonResponse::error('The investment amount should be between ' . getCurrencySymbol().shortAmount($binaryPlan->minimum) . ' and ' . getCurrencySymbol().shortAmount($binaryPlan->maximum));
            }
        }else{
            if ($request->input('amount') != $binaryPlan->amount) {
                return ApiJsonResponse::error('The investment amount should be between ' . getCurrencySymbol().shortAmount($binaryPlan->amount));
            }
        }

        $this->investmentService->executeInvestment($request->input('amount'), $wallet, $binaryPlan);
        return ApiJsonResponse::success("Investment has been added successfully");
    }


    /**
     * @param ReInvestmentRequest $request
     * @return JsonResponse
     */
    public function makeReinvestment(ReInvestmentRequest $request): JsonResponse
    {
        $investmentLog = $this->investmentService->findByUid($request->input('uid'));
        if ($investmentLog->status != Status::PROFIT_COMPLETED->value){
            return ApiJsonResponse::notFound("The investment log provided is invalid");
        }

        $wallet = Auth::user()->wallet;
        $this->investmentService->ensureUserOwnership($investmentLog->user);

        $account = $this->walletService->findBalanceByWalletType(WalletType::PRIMARY->value, $wallet);
        $investmentAmount = $investmentLog->amount + $request->input('amount', 0);

        if($investmentAmount > Arr::get($account, 'balance')){
            return ApiJsonResponse::error("Your primary account balance is insufficient for this investment.");
        }

        $details = 'Investment completed. Amount returned for re-investment: '.getCurrencySymbol().($investmentLog->amount);
        $this->investmentService->investmentReturnAmount($investmentLog->amount, $investmentLog, Status::COMPLETED, $details, true);
        $this->investmentService->executeInvestment($investmentAmount, $wallet, $investmentLog->plan);

        $investmentLog->notify(new InvestmentLogNotification(NotificationType::RE_INVEST));
        return ApiJsonResponse::success("Re-investment has been created successfully");
    }

    /**
     * @param InvestmentReturnRequest $request
     * @return JsonResponse
     */
    public function completeInvestmentTransfer(InvestmentReturnRequest $request): JsonResponse
    {
        $investmentLog = $this->investmentService->findByUid($request->input('uid'));
        if ($investmentLog->status == Status::PROFIT_COMPLETED->value && $investmentLog->profit == 0){
            return ApiJsonResponse::error("You are not authorized to access this investment");
        }

        $this->investmentService->ensureUserOwnership($investmentLog->user);
        $amount =  $investmentLog->amount;
        $details = 'Investment Completed: '.getCurrencySymbol().($amount).' added to primary wallet';
        $this->investmentService->investmentReturnAmount($amount, $investmentLog, Status::COMPLETED, $details);

        $this->investmentService->agentCalculateCommission($investmentLog);
        $investmentLog->notify(new InvestmentLogNotification(NotificationType::COMPLETE));
        return ApiJsonResponse::success("Investment has been transfer Funding successfully");
    }

    /**
     * @param InvestmentReturnRequest $request
     * @return JsonResponse
     */
    public function cancel(InvestmentReturnRequest $request): JsonResponse
    {
        $investmentLog = $this->investmentService->findByUid($request->input('uid'));
        if ($investmentLog->status != Status::INITIATED->value && $investmentLog->profit != 0){
            return ApiJsonResponse::error("You are not authorized to access this investment");
        }

        $this->investmentService->ensureUserOwnership($investmentLog->user);
        $setting = SettingService::getSetting();

        $amount =  calculateCommissionCut($investmentLog->amount, getArrayValue($setting->commissions_charge, 'investment_cancel_charge'));
        $details = 'Investment Cancelled & Refunded';
        $this->investmentService->investmentReturnAmount($amount, $investmentLog, Status::CANCELLED, $details);

        $investmentLog->notify(new InvestmentLogNotification(NotificationType::CANCEL));
        return ApiJsonResponse::success( "Investment has been cancelled successfully");
    }
}
