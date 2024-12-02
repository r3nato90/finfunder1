<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Payment\NotificationType;
use App\Enums\Payment\Withdraw\Status;
use App\Enums\Transaction\Type;
use App\Enums\Transaction\WalletType;
use App\Enums\Transaction\Source;
use App\Http\Controllers\Controller;
use App\Notifications\WithdrawNotification;
use App\Services\Payment\TransactionService;
use App\Services\Payment\WalletService;
use App\Services\Payment\WithdrawService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class WithdrawController extends Controller
{
    public function __construct(
        protected WithdrawService $withdrawService,
        protected TransactionService $transactionService,
        protected WalletService $walletService,
    ){

    }

    public function index(): View
    {
        $setTitle = __('admin.withdraw.page_title.index');
        $withdrawLogs = $this->withdrawService->fetchWithdrawLogs(with: ['user', 'withdrawMethod']);

        return view('admin.withdraw.index', compact(
            'setTitle',
            'withdrawLogs'
        ));
    }

    /**
     * @param int $id
     * @return View
     */
    public function details(int $id): View
    {
        $setTitle = __('admin.withdraw.page_title.details');
        $withdraw = $this->withdrawService->findById($id);

        if(!$withdraw){
            abort(404);
        }

        return view('admin.withdraw.details', compact(
            'setTitle',
            'withdraw',
        ));
    }

    /**
     * @param Request $request
     * @param int|string $id
     * @return RedirectResponse
     */
    public function update(Request $request, int|string $id): RedirectResponse
    {
        $request->validate([
            'status' => ['required', Rule::in(Status::SUCCESS->value, Status::CANCEL->value)]
        ]);

        $withdraw = $this->withdrawService->findById($id);
        $wallet = $withdraw?->user?->wallet;

        if(!$withdraw || !$wallet || $withdraw->status != Status::PENDING->value){
            abort(404);
        }

        if($request->input('status') == Status::CANCEL->value){
            DB::transaction(function () use ($withdraw, $wallet) {
                $wallet->primary_balance += $withdraw->amount;
                $wallet->save();

                $this->transactionService->save($this->transactionService->prepParams([
                    'user_id' => $withdraw->user_id,
                    'amount' => $withdraw->amount,
                    'wallet' => $this->walletService->findBalanceByWalletType(WalletType::PRIMARY->value, $wallet),
                    'charge' => $withdraw->charge,
                    'trx' => $withdraw->trx,
                    'type' => Type::PLUS->value,
                    'wallet_type' => WalletType::PRIMARY->value,
                    'source' => Source::ALL->value,
                    'details' => 'Withdrawal canceled: Amount returned to user\'s primary account.',
                ]));
            });
            $withdraw->notify(new WithdrawNotification(NotificationType::REJECTED));
        }else{
            $withdraw->notify(new WithdrawNotification(NotificationType::APPROVED));
        }

        $withdraw->status = $request->input('status');
        $withdraw->details = $request->input('details');
        $withdraw->save();

        return back()->with('notify', [['success', __('admin.withdraw.notify.update.success')]]);
    }
}
