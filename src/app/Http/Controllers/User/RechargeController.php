<?php

namespace App\Http\Controllers\User;

use App\Enums\Matrix\PinStatus;
use App\Enums\Status;
use App\Enums\Transaction\WalletType;
use App\Http\Controllers\Controller;
use App\Http\Requests\PinGenerateRequest;
use App\Http\Requests\PinRechargeRequest;
use App\Services\Payment\DepositService;
use App\Services\Payment\TransactionService;
use App\Services\Payment\WalletService;
use App\Services\Payment\WithdrawService;
use App\Services\PinGenerateService;
use App\Services\SettingService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RechargeController extends Controller
{
    public function __construct(
        protected PinGenerateService $pinGenerateService,
        protected WalletService $walletService,
        protected TransactionService $transactionService,
        protected WithdrawService $withdrawService,
        protected DepositService $depositService,
        protected UserService $userService
    ) {

    }

    public function index(): View
    {
        $setTitle = "Recharge Your Wallet";
        $pins = $this->pinGenerateService->getPinsByPaginate(userId: Auth::id());

        return view('user.recharge', compact(
            'setTitle',
            'pins'
        ));
    }

    public function save(PinRechargeRequest $request): RedirectResponse
    {
        $setting = SettingService::getSetting();

        if (getArrayValue($setting->system_configuration, 'e_pin.value') != \App\Enums\Status::ACTIVE->value){
            abort(404);
        }

        $pinNumber = $this->pinGenerateService->findByPinNumber($request->input('pin_number'));
        if (!$pinNumber) {
            return back()->with('notify', [['error', 'Recharge E-pin not found']]);
        }

        if ($pinNumber->status == PinStatus::USED->value) {
            return back()->with('notify', [['error', 'Recharge E-pin already used.']]);
        }

        $user = Auth::user();
        $this->pinGenerateService->recharge($pinNumber, $user, $user->wallet);

        return back()->with('notify', [['success', 'Balance has been added to your primary wallet']]);
    }

    public function generate(PinGenerateRequest $request): RedirectResponse
    {
        $setting = SettingService::getSetting();

        if(getArrayValue($setting->system_configuration, 'e_pin.value') == Status::INACTIVE->value){
            abort(404);
        }

        $user = Auth::user();
        $wallet = $user->wallet;
        $charge = (($request->input('amount') / 100) * getArrayValue($setting->commissions_charge, 'e_pin_charge'));
        $account = $this->walletService->findBalanceByWalletType(WalletType::PRIMARY->value, $wallet);
        $amount = $request->input('amount');

        if($amount + $charge > Arr::get($account, 'balance')){
            return back()->with('notify', [['warning', "Your primary account balance is insufficient for generate pin."]]);
        }

        $this->pinGenerateService->generate($request, $user, $wallet, $charge);
        return back()->with('notify', [['success', __('admin.pin.notify.create.success')]]);
    }

}
