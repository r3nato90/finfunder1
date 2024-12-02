<?php

namespace App\Http\Controllers\Api\User;

use App\Concerns\CustomValidation;
use App\Enums\Payment\NotificationType;
use App\Http\Controllers\Controller;
use App\Http\Resources\WithdrawGatewayResource;
use App\Http\Resources\WithdrawResource;
use App\Notifications\WithdrawNotification;
use App\Services\Payment\TransactionService;
use App\Services\Payment\WalletService;
use App\Services\Payment\WithdrawGatewayService;
use App\Services\Payment\WithdrawService;
use App\Services\UserService;
use App\Utilities\Api\ApiJsonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class WithdrawController extends Controller
{
    use CustomValidation;
    public function __construct(
        protected WithdrawService $withdrawService,
        protected UserService $userService,
        protected TransactionService $transactionService,
        protected WalletService $walletService,
        protected WithdrawGatewayService $withdrawGatewayService
    ){

    }
    public function index(): JsonResponse
    {
        $withdraws = $this->withdrawService->fetchWithdrawLogs(userId: Auth::id(), with: ['user', 'withdrawMethod']);

        return ApiJsonResponse::success("Withdraw information fetched successfully.", [
            'withdraw_gateways' => WithdrawGatewayResource::collection($this->withdrawGatewayService->fetchActiveWithdrawMethod()),
            'withdraw_logs' => WithdrawResource::collection($withdraws),
            'withdraw_meta' => paginateMeta($withdraws),
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'gt:0'],
        ]);

        $wallet =  Auth::user()->wallet;
        if ($request->input('amount') > $wallet->primary_balance) {
            return ApiJsonResponse::error("Your request amount is larger then your current primary balance.");
        }

        $withdrawMethod = $this->withdrawGatewayService->findById($request->input('id'));
        if(!$withdrawMethod){
            return ApiJsonResponse::error("Withdraw method not found.");
        }

        $validationError = $this->withdrawService->validateWithdrawalAmount($request->input('amount'), $withdrawMethod, Auth::user()->wallet);
        if ($validationError != null) {
            return ApiJsonResponse::error("Withdraw method not found.", $validationError);
        }

        $withdrawLog = $this->withdrawService->save(
            $this->withdrawService->prepParams($withdrawMethod, $request)
        );

        $this->validate($request, $this->parameterValidation((array)$withdrawMethod->parameter));
        $this->withdrawService->execute($withdrawLog, $withdrawMethod, $wallet, $request);

        $withdrawLog->notify(new WithdrawNotification(NotificationType::REQUESTED));
        return ApiJsonResponse::success("Withdraw request sent successfully.");
    }
}
