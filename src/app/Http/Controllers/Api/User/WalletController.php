<?php

namespace App\Http\Controllers\Api\User;

use App\Concerns\CustomValidation;
use App\Enums\Transaction\Source;
use App\Enums\Transaction\Type;
use App\Enums\Transaction\WalletType;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransferOtherRequest;
use App\Http\Requests\TransferRequest;
use App\Services\Payment\TransactionService;
use App\Services\Payment\WalletService;
use App\Services\Payment\WithdrawGatewayService;
use App\Services\Payment\WithdrawService;
use App\Services\SettingService;
use App\Services\UserService;
use App\Utilities\Api\ApiJsonResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
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
        $users = $this->userService->getUserByColumn(['id', 'uuid', 'email']);
        return ApiJsonResponse::success('User info fetched successfully', $users);
    }

    /**
     * @throws Exception
     */
    public function transferWithinOwnAccount(TransferRequest $request): JsonResponse
    {
        try {
            $amount = $request->input('amount');
            $userId = (int)Auth::id();
            [$wallet, $account] = $this->walletService->checkWalletBalance($amount, $request->integer('account'), true);
            $wallet->primary_balance += $request->input('amount');
            $wallet->save();

            $accountName = Arr::get($account, 'name');
            $wallet->$accountName -= $request->input('amount');
            $wallet->save();

            $this->walletService->updateTransaction(
                $userId,
                $amount,
                Type::MINUS,
                Source::ALL,
                $this->walletService->findBalanceByWalletType(WalletType::INVESTMENT->value, $wallet),
                'Reduced '.replaceInputTitle($accountName). ' by '. getCurrencySymbol().$request->input('amount') . ' added to primary account'
            );

            $this->walletService->updateTransaction(
                $userId,
                $amount,
                Type::PLUS,
                Source::ALL,
                $this->walletService->findBalanceByWalletType(WalletType::PRIMARY->value, $wallet),
                getCurrencySymbol().$request->input('amount').' was added to the primary balance from the '. replaceInputTitle($accountName)
            );

            return ApiJsonResponse::success(replaceInputTitle($accountName).' has been transfer');

        }catch (Exception $exception){
            return ApiJsonResponse::error($exception->getMessage());
        }
    }

    /**
     * @param TransferOtherRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function transferToOtherUser(TransferOtherRequest $request): JsonResponse
    {
        $setting = SettingService::getSetting();
        if (getArrayValue($setting->system_configuration, 'balance_transfer.value') != \App\Enums\Status::ACTIVE->value) {
            return ApiJsonResponse::error("Balance transfer currently off");
        }

        $user = $this->userService->findByUuid($request->input('uuid'));
        if (!$user) {
            return ApiJsonResponse::error("Receiver user not found");
        }

        if ($user->id == Auth::id()) {
            return ApiJsonResponse::error("You can not transfer balance to self account.");
        }

        $this->walletService->checkWalletBalance($request->input('amount'), WalletType::PRIMARY->value);
        $this->walletService->executeTransfer($request->input('amount'), $user);

        return ApiJsonResponse::success("Balance has been transfer");
    }
}
