<?php

namespace App\Http\Controllers\User;

use App\Enums\Transaction\Source;
use App\Enums\Transaction\Type;
use App\Enums\Transaction\WalletType;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransferOtherRequest;
use App\Http\Requests\TransferRequest;
use App\Services\Payment\WalletService;
use App\Services\SettingService;
use App\Services\UserService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WalletController extends Controller
{
    public function __construct(
        protected WalletService $walletService,
        protected UserService $userService,
    ){
    }

    public function index(): View
    {
        $setTitle = "Wallet Top-up";
        $users = $this->userService->getUserByColumn(['id', 'email']);

        return view('user.wallet-top-up', compact(
            'setTitle',
            'users',
        ));
    }

    public function transferWithinOwnAccount(TransferRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $amount = $request->input('amount');
            $userId = (int)Auth::id();
            [$wallet, $account] = $this->walletService->checkWalletBalance($amount, $request->integer('account'), true);
            $wallet->primary_balance += $request->input('amount');
            $wallet->save();

            $accountName = Arr::get($account, 'name');
            $this->walletService->updateTransaction(
                $userId,
                $amount,
                Type::PLUS,
                Source::ALL,
                $this->walletService->findBalanceByWalletType(WalletType::PRIMARY->value, $wallet),
                getCurrencySymbol().$request->input('amount').' was added to the primary balance from the '. replaceInputTitle($accountName)
            );

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

            return back()->with('notify', [['success', replaceInputTitle($accountName).' has been transfer']]);

        }catch (\Exception $exception){
            return back()->with('notify', [['error', $exception->getMessage()]]);
        }
    }


    public function transferToOtherUser(TransferOtherRequest $request): \Illuminate\Http\RedirectResponse
    {
        $setting = SettingService::getSetting();

        if (getArrayValue($setting->system_configuration, 'balance_transfer.value') != \App\Enums\Status::ACTIVE->value) {
            abort(404);
        }

        try {
            $user = $this->userService->findByUuid($request->input('uuid'));
            if (!$user) {
                return back()->with('notify', [['error', "Receiver user not found"]]);
            }

            if ($user->id == Auth::id()) {
                return back()->with('notify', [['error', "You can not transfer balance to self account."]]);
            }

            $this->walletService->checkWalletBalance($request->input('amount'), WalletType::PRIMARY->value);
            $this->walletService->executeTransfer($request->input('amount'), $user);

            return back()->with('notify', [['success', "Balance has been transfer"]]);

        }catch (\Exception $exception){
            return back()->with('notify', [['error', $exception->getMessage()]]);
        }
    }

}
