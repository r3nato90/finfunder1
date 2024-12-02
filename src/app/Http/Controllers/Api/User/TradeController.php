<?php

namespace App\Http\Controllers\Api\User;

use App\Enums\Trade\TradeType;
use App\Enums\Transaction\Type;
use App\Enums\Transaction\WalletType;
use App\Http\Controllers\Controller;
use App\Http\Requests\TradeRequest;
use App\Http\Resources\CryptoResource;
use App\Http\Resources\TradeResource;
use App\Http\Resources\WalletResource;
use App\Services\Payment\WalletService;
use App\Services\SettingService;
use App\Services\Trade\ActivityLogService;
use App\Services\Trade\CryptoCurrencyService;
use App\Services\Trade\ParameterService;
use App\Utilities\Api\ApiJsonResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TradeController extends Controller
{
    public function __construct(
        protected ActivityLogService $activityLogService,
        protected CryptoCurrencyService $cryptoCurrencyService,
        protected ParameterService $parameterService,
        protected WalletService $walletService,
    ){
    }
    public function index(): JsonResponse
    {
        $userId = Auth::id();
        $tradeLogs = $this->activityLogService->getByUser($userId, TradeType::TRADE);
        $tradePracticeLogs = $this->activityLogService->getByUser($userId, TradeType::PRACTICE);

        return ApiJsonResponse::success('Trade statistics fetched data', [
            'trade_logs' => TradeResource::collection($tradeLogs),
            'trade_logs_meta' => paginateMeta($tradeLogs),
            'trade_practice_logs' => TradeResource::collection($tradePracticeLogs),
            'trade_practice_logs_meta' => paginateMeta($tradePracticeLogs),
        ]);
    }

    public function crypto(): JsonResponse
    {
        $crypto = $this->cryptoCurrencyService->getActiveCryptoCurrencyByPaginate();
        return ApiJsonResponse::success('Trade cryptos fetched data', [
            'crypto_currency' => CryptoResource::collection($crypto),
            'crypto_currency_meta' => paginateMeta($crypto),
        ]);
    }

    /**
     * @param string $pair
     * @return JsonResponse
     */
    public function trade(string $pair): JsonResponse
    {
        $setting = SettingService::getSetting();
        if (getArrayValue($setting->system_configuration, 'binary_trade.value') != \App\Enums\Status::ACTIVE->value) {
            return ApiJsonResponse::error("Currently binary trade off");
        }

        $userId = (int)Auth::id();
        $crypto = $this->cryptoCurrencyService->findByPair($pair);
        $parameters = $this->parameterService->activeParameter();
        $tradeLogs = $this->activityLogService->getByUser($userId, TradeType::TRADE, true);

        return ApiJsonResponse::success('Trade fetched data',[
            'crypto' => $crypto,
            'parameters' => $parameters,
            'trade_logs' => TradeResource::collection($tradeLogs),
        ]);
    }

    /**
     * @param TradeRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function store(TradeRequest $request, $id): JsonResponse
    {
        try {
            $parameter = $this->parameterService->findById($request->integer('parameter_id'));
            $crypto = $this->cryptoCurrencyService->findById((int)$id);
            if(!$parameter || !$crypto){
                return ApiJsonResponse::error("Crypto not found");
            }

            $walletType = $request->integer('type') == TradeType::TRADE->value ? WalletType::TRADE->value : WalletType::PRACTICE->value;
            [$wallet, $account] = $this->walletService->checkWalletBalance($request->input('amount'), $walletType, true);
            $this->activityLogService->executeTrade($request, $wallet, $account, Type::MINUS, $parameter, $crypto);

            return ApiJsonResponse::success('Trade has been generated');

        }catch (Exception $exception){
            return ApiJsonResponse::error($exception->getMessage());
        }
    }

    public function statistics(): JsonResponse
    {
        $user = Auth::user();
        $userId = $user->id;
        return ApiJsonResponse::success('Trade statistics fetched data', [
            'statistics' => $this->activityLogService->getTradeReport($userId),
            'monthly_report' => $this->activityLogService->dayReport($userId),
            'wallet' => new WalletResource($user->wallet),
        ]);
    }
}
