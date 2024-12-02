<?php

namespace App\Services\Investment\Staking;

use App\Enums\Investment\Staking\Status;
use App\Enums\Transaction\Source;
use App\Enums\Transaction\Type;
use App\Enums\Transaction\WalletType;
use App\Models\StakingInvestment;
use App\Models\StakingPlan;
use App\Models\Wallet;
use App\Notifications\StakingInvestmentNotification;
use App\Services\Payment\TransactionService;
use App\Services\Payment\WalletService;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Facades\Auth;

class StakingInvestmentService
{
    public function getPaginate(): AbstractPaginator
    {
        return StakingInvestment::filter(request()->all())->with('user')->orderBy('id', 'desc')->paginate(getPaginate());
    }


    public function prepParams(Request $request, StakingPlan $plan): array
    {
        $interest = $request->input('amount') * $plan->interest_rate / 100;

        return [
            'user_id' => $request->user()->id,
            'staking_plan_id' => $plan->id,
            'amount' => $request->input('amount'),
            'interest' => $interest,
            'expiration_date' => now()->addDays($plan->duration),
            'status' => Status::RUNNING->value,
        ];
    }

    public function save(array $data): StakingInvestment
    {
        return StakingInvestment::create($data);
    }

    public function executeInvestment(Request $request, Wallet $wallet, StakingPlan $stakingPlan): void
    {
        $amount = $request->input('amount');

        $wallet->primary_balance -= $amount;
        $wallet->save();

        $invest = $this->save($this->prepParams($request, $stakingPlan));
        $transaction = resolve(TransactionService::class);
        $walletService = resolve(WalletService::class);

        $transaction->save($transaction->prepParams([
            'user_id' => Auth::id(),
            'amount' => $amount,
            'type' => Type::MINUS,
            'trx' => getTrx(),
            'details' => getCurrencySymbol() . $amount . ' staking invested for a duration of ' . $stakingPlan->duration . ' days',
            'wallet' => $walletService->findBalanceByWalletType(WalletType::PRIMARY->value, $wallet),
            'source' => Source::INVESTMENT->value
        ]));

        $invest->notify(new StakingInvestmentNotification());
    }


    public function cron(): void
    {
        $stakingInvests = StakingInvestment::with('user')
            ->where('status', Status::RUNNING->value)
            ->where('expiration_date', '<=', now())
            ->get();

        foreach ($stakingInvests as $invest) {
            $user = $invest->user;
            $wallet = $user->wallet->fresh();

            $wallet->investment_balance += $invest->amount + $invest->interest;
            $wallet->save();

            $invest->status = Status::COMPLETED->value;
            $invest->save();

            $transaction = resolve(TransactionService::class);
            $walletService = resolve(WalletService::class);

            $transaction->save($transaction->prepParams([
                'user_id' => $user->id,
                'amount' => $invest->amount + $invest->interest,
                'type' => Type::PLUS,
                'trx' => getTrx(),
                'details' => getCurrencySymbol() . ($invest->amount + $invest->interest) . ' Staking invested return',
                'wallet' => $walletService->findBalanceByWalletType(WalletType::INVESTMENT->value, $wallet),
                'source' => Source::INVESTMENT->value
            ]));
        }
    }
}
