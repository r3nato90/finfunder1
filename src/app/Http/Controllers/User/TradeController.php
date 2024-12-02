<?php

namespace App\Http\Controllers\User;

use App\Enums\Trade\TradeType;
use App\Enums\Transaction\Type;
use App\Enums\Transaction\WalletType;
use App\Http\Controllers\Controller;
use App\Http\Requests\TradeRequest;
use App\Services\Payment\WalletService;
use App\Services\SettingService;
use App\Services\Trade\ActivityLogService;
use App\Services\Trade\CryptoCurrencyService;
use App\Services\Trade\ParameterService;
use App\Services\UserService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TradeController extends Controller
{
    public function __construct(
        protected WalletService $walletService,
        protected UserService $userService,
        protected ActivityLogService $activityLogService,
        protected CryptoCurrencyService $cryptoCurrencyService,
        protected ParameterService $parameterService,
    ){
    }

    public function index(): View
    {
        $setting = SettingService::getSetting();
        if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::TRADE_PREDICTION->name)) == 0){
            abort(404);
        }

        $setTitle = "Trades";
        $cryptoCurrency = $this->cryptoCurrencyService->getActiveCryptoCurrencyByPaginate();

        return view('user.trade.index', compact(
           'setTitle',
            'cryptoCurrency',
        ));
    }

    public function tradeLog(): View
    {
        $setting = SettingService::getSetting();
        if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::TRADE_PREDICTION->name)) == 0){
            abort(404);
        }

        $setTitle = "Trade logs";
        $userId = (int)Auth::id();
        [$days, $amount] = $this->activityLogService->dayReport($userId);
        $trade = $this->activityLogService->getTradeReport($userId);
        $tradeLogs = $this->activityLogService->getByUser($userId, TradeType::TRADE);

        return view('user.trade.trade_log', compact(
            'setTitle',
            'tradeLogs',
            'trade',
            'days',
            'amount',
        ));
    }

    public function practiceLog(): View
    {
        $setting = SettingService::getSetting();
        if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::TRADE_PREDICTION->name)) == 0){
            abort(404);
        }

        $setTitle = "Practice logs";
        $userId = Auth::id();
        $practiceLogs = $this->activityLogService->getByUser($userId, TradeType::PRACTICE);

        return view('user.trade.practice_log', compact(
            'setTitle',
            'practiceLogs',
        ));
    }

   /**
     * @param string $pair
     * @return View
     */
    public function trade(string $pair): View
    {
        $setting = SettingService::getSetting();
        if (getArrayValue($setting->system_configuration, 'binary_trade.value') != \App\Enums\Status::ACTIVE->value) {
            abort(404);
        }

        if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::TRADE_PREDICTION->name)) == 0){
            abort(404);
        }

        $setTitle = "Trade now";
        $userId = (int)Auth::id();
        $crypto = $this->cryptoCurrencyService->findByPair($pair);
        $parameters = $this->parameterService->activeParameter();
        $tradeLogs = $this->activityLogService->getByUser($userId, TradeType::TRADE, true);

        return view('user.trade.trading', compact(
            'setTitle',
            'crypto',
            'parameters',
            'tradeLogs',
        ));
    }

    /**
     * @param string $pair
     * @return View
     */
    public function practice(string $pair): View
    {
        $setting = SettingService::getSetting();
        if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::TRADE_PREDICTION->name)) == 0){
            abort(404);
        }

        if (getArrayValue($setting->system_configuration, 'practice_trade.value') != \App\Enums\Status::ACTIVE->value) {
            abort(404);
        }

        $setTitle = "Practice now";
        $userId = (int)Auth::id();
        $crypto = $this->cryptoCurrencyService->findByPair($pair);
        $parameters = $this->parameterService->activeParameter();
        $tradeLogs = $this->activityLogService->getByUser($userId, TradeType::PRACTICE, true);

        return view('user.trade.trading', compact(
            'setTitle',
            'crypto',
            'parameters',
            'tradeLogs',
        ));
    }

    /**
     * @throws Exception
     */
    public function store(TradeRequest $request, $id)
    {
        $setting = SettingService::getSetting();
        if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::TRADE_PREDICTION->name)) == 0){
            abort(404);
        }

        try {
            $parameter = $this->parameterService->findById($request->integer('parameter_id'));
            $crypto = $this->cryptoCurrencyService->findById((int)$id);

            if(!$parameter || !$crypto){
                abort(404);
            }

            $walletType = $request->integer('type') == TradeType::TRADE->value ? WalletType::TRADE->value : WalletType::PRACTICE->value;

            [$wallet, $account] = $this->walletService->checkWalletBalance($request->input('amount'), $walletType, true);
            $this->activityLogService->executeTrade($request, $wallet, $account, Type::MINUS, $parameter, $crypto);

            $notify[] = ['success', "Trade has been generated"];
            return back()->withNotify($notify);

        }catch (Exception $exception){

            $notify[] = ['warning', $exception->getMessage()];
            return back()->withNotify($notify);
        }
    }
}
