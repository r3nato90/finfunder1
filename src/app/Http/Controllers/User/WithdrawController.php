<?php

namespace App\Http\Controllers\User;

use App\Concerns\CustomValidation;
use App\Enums\Payment\Withdraw\MethodStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\WithdrawProcessRequest;
use App\Services\Payment\TransactionService;
use App\Services\Payment\WalletService;
use App\Services\Payment\WithdrawGatewayService;
use App\Services\Payment\WithdrawService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

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

    public function index(): View
    {
        $setTitle = "Cash out";
        $userId = Auth::id();
        $withdrawMethods = $this->withdrawGatewayService->fetchActiveWithdrawMethod();
        $withdrawLogs = $this->withdrawService->fetchWithdrawLogs(userId: $userId, with: ['user', 'withdrawMethod']);

        return view('user.withdraw.index', compact(
            'setTitle',
            'withdrawMethods',
            'withdrawLogs',
        ));
    }

    public function process(WithdrawProcessRequest $request)
    {
        $withdrawMethod = $this->withdrawGatewayService->findById($request->integer('id'));

        if(!$withdrawMethod){
            abort(404);
        }

        $amount = $request->input('amount');
        $validationError = $this->withdrawService->validateWithdrawalAmount($amount, $withdrawMethod, Auth::user()->wallet);

        if ($validationError != null) {
            return back()->withNotify([$validationError]);
        }

        $withdrawLog = $this->withdrawService->save(
            $this->withdrawService->prepParams($withdrawMethod, $request)
        );

        return redirect()->route('user.withdraw.preview', $withdrawLog->uid);
    }


    /**
     * @param string $uid
     * @return View
     */
    public function preview(string $uid): View
    {
        $withdrawLog = $this->withdrawService->findByUidWithdrawLog($uid);

        if(!$withdrawLog){
            abort(404);
        }

        $setTitle = 'Withdraw preview';
        return view('user.withdraw.preview', compact(
            'setTitle',
            'withdrawLog',
            'uid',
        ));
    }


    /**
     * @param Request $request
     * @param string $uid
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function makeSuccess(Request $request, string $uid): RedirectResponse
    {
        $withdrawLog = $this->withdrawService->findByUidWithdrawLog($uid);

        if(!$withdrawLog){
            abort(404);
        }

        $gateway = $withdrawLog->withdrawMethod;
        if (!$gateway ||  $gateway->status == MethodStatus::INACTIVE->value) {
            abort(404);
        }

        $this->validate($request, $this->parameterValidation((array)$gateway->parameter));

        $wallet =  Auth::user()->wallet;
        if ($withdrawLog->amount > $wallet->primary_balance) {
            return back()->with('notify', [['error', 'Your request amount is larger then your current primary balance.']]);
        }

        $this->withdrawService->execute($withdrawLog, $gateway, $wallet, $request);
        return redirect(route('user.withdraw.index'))->with('notify', [['success', 'Withdraw request sent successfully.']]);
    }
}
