<?php

namespace App\Services\Payment;

use App\Enums\Payment\Withdraw\Status;
use App\Enums\Transaction\Source;
use App\Enums\Transaction\Type;
use App\Enums\Transaction\WalletType;
use App\Models\Wallet;
use App\Models\WithdrawLog;
use App\Models\WithdrawMethod;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WithdrawService
{
    public function __construct(TransactionService $transactionService)
    {

    }
    /**
     * @param int $id
     * @return WithdrawLog|null
     */
    public function findById(int $id): ?WithdrawLog
    {
        return WithdrawLog::find($id);
    }


    /**
     * @param WithdrawMethod $withdrawMethod
     * @param Request $request
     * @return array
     */
    public function prepParams(WithdrawMethod $withdrawMethod, Request $request): array
    {
        $amount = $request->input('amount');
        $charge = $withdrawMethod->fixed_charge + ($amount * $withdrawMethod->percent_charge / 100);
        $afterCharge = $amount - $charge;

        return [
            'uid' => Str::uuid(),
            'withdraw_method_id' => $withdrawMethod->id,
            'user_id' => Auth::id(),
            'currency' => $withdrawMethod->currency,
            'rate' => $withdrawMethod->rate,
            'amount' => $amount,
            'charge' => $charge,
            'final_amount' => $afterCharge * $withdrawMethod->rate,
            'after_charge' => $afterCharge,
            'trx' => getTrx(),
            'status' => Status::INITIATED->value,
        ];
    }


    /**
     * @param array $data
     * @return WithdrawLog
     */
    public function save(array $data): WithdrawLog
    {
        return WithdrawLog::create($data);
    }


    /**
     * @param int|float|string $amount
     * @param WithdrawMethod $withdrawMethod
     * @param Wallet $wallet
     * @return string[]|null
     */
    public function validateWithdrawalAmount(int|float|string $amount, WithdrawMethod $withdrawMethod,Wallet $wallet): ?array
    {
        if ($amount < $withdrawMethod->min_limit) {
            return ['error', 'Your requested amount is smaller than minimum amount.'];
        }

        if ($amount > $withdrawMethod->max_limit) {
            return ['error', 'Your requested amount is larger than maximum amount.'];
        }

        if ($amount > $wallet->primary_balance) {
            return ['error', 'You do not have sufficient balance for withdrawal.'];
        }

        return null;
    }


    /**
     * @param string $uid
     * @return WithdrawLog|null
     */
    public function findByUidWithdrawLog(string $uid): ?WithdrawLog
    {
        return WithdrawLog::where('uid', $uid)
            ->where('status', Status::INITIATED->value)
            ->orderBy('id', 'desc')
            ->first();
    }


    /**
     *
     * @param int|string|null $userId
     * @param array $with
     * @return AbstractPaginator
     */
    public function fetchWithdrawLogs(int|string $userId = null, array $with = []): AbstractPaginator
    {
        return WithdrawLog::filter(request()->all())
            ->when(!is_null($userId), fn ($query) => $query->where('user_id', $userId))
            ->latest()
            ->when(!empty($with), fn ($query) => $query->with($with))
            ->paginate(getPaginate());
    }

    public function getApiReport(int|string $userId = null): array
    {
        $withdraw = $this->getWithdrawReport($userId);

        return  [
            'total' => is_null($withdraw->total) ? 0 : $withdraw->total,
            'pending' => is_null($withdraw->pending) ? 0 : $withdraw->pending,
            'rejected' => is_null($withdraw->rejected) ? 0 : $withdraw->rejected,
            'charge' => is_null($withdraw->charge) ? 0 : $withdraw->charge,
        ];
    }


    private function getWithdrawReport(int|string $userId = null)
    {
        $query = WithdrawLog::query();
        if(!is_null($userId)){
            $query->where('user_id', $userId);
        }

        return  $query->selectRaw('
            SUM(CASE WHEN status = ? THEN amount ELSE 0 END) as total,
            SUM(CASE WHEN status = ? THEN amount ELSE 0 END) as pending,
            SUM(CASE WHEN status = ? THEN amount ELSE 0 END) as rejected,
            SUM(CASE WHEN status = ? THEN charge ELSE 0 END) as charge
        ', [
            \App\Enums\Payment\Withdraw\Status::SUCCESS->value,
            \App\Enums\Payment\Withdraw\Status::PENDING->value,
            \App\Enums\Payment\Withdraw\Status::CANCEL->value,
            \App\Enums\Payment\Withdraw\Status::SUCCESS->value,
        ])->first();
    }

    public function getReport(int|string $userId = null)
    {
        return $this->getWithdrawReport($userId);
    }

    /**
     * @param int|float $amount
     * @param int|float $charge
     * @param int|string|null $userId
     * @return array
     */
    public function withdrawParams(int|float $amount, int|float $charge = 0, int|string $userId = null): array
    {
        return  [
            'uid' => Str::uuid(),
            'withdraw_method_id' => 0,
            'user_id' => is_null($userId) ? Auth::id() : $userId,
            'currency' => getCurrencyName(),
            'rate' => 1,
            'amount' => $amount,
            'charge' => $charge,
            'final_amount' => $amount-$charge,
            'after_charge' => $amount-$charge,
            'trx' => getTrx(),
            'status' => \App\Enums\Payment\Withdraw\Status::SUCCESS->value,
        ];
    }


    /**
     * @param WithdrawLog $withdrawLog
     * @param WithdrawMethod $withdrawMethod
     * @param Wallet $wallet
     * @param Request $request
     * @return void
     */
    public function execute(WithdrawLog $withdrawLog, WithdrawMethod $withdrawMethod, Wallet $wallet, Request $request): void
    {
        DB::transaction(function () use ($withdrawLog, $request, $withdrawMethod, $wallet) {
            $withdrawLog->status = Status::PENDING->value;
            $withdrawLog->meta = $request->only(array_keys($withdrawMethod->parameter));
            $withdrawLog->save();

            $wallet->primary_balance -= $withdrawLog->amount;
            $wallet->save();

            $transactionService = resolve(TransactionService::class);
            $walletService = resolve(WalletService::class);

            $transactionService->save($transactionService->prepParams([
                'user_id' => Auth::id(),
                'amount' => $withdrawLog->amount,
                'wallet' => $walletService->findBalanceByWalletType(WalletType::PRIMARY->value, $wallet),
                'charge' => $withdrawLog->charge,
                'trx' => $withdrawLog->trx,
                'type' => Type::MINUS->value,
                'wallet_type' => WalletType::PRIMARY->value,
                'source' => Source::ALL->value,
                'details' => "Withdraw ".shortAmount($withdrawLog->final_amount)." ".$withdrawLog->currency." via ".$withdrawLog->withdrawMethod->name,
            ]));
        });
    }
}
