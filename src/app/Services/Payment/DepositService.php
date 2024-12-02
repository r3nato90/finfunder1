<?php

namespace App\Services\Payment;

use App\Enums\Payment\Deposit\Status;
use App\Enums\Transaction\WalletType;
use App\Models\Deposit;
use App\Models\PaymentGateway;
use App\Models\WithdrawLog;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Facades\DB;

class DepositService
{
    /**
     * @param PaymentGateway $paymentGateway
     * @param float|int $amount
     * @param Request $request
     * @return array
     */
    public function prepParams(PaymentGateway $paymentGateway, float|int $amount, Request $request): array
    {
        $finalAmount = calculateCommissionCut($amount, $paymentGateway->percent_charge);
        return [
            'user_id' => Auth::id(),
            'payment_gateway_id' => $paymentGateway->id,
            'rate' => $paymentGateway->rate,
            'amount' => $amount,
            'final_amount' => $finalAmount,
            'charge' => $amount - $finalAmount,
            'trx' => getTrx(),
            'wallet_type' => $request->input('wallet'),
            'crypto_meta' => [
                'currency' => $request->input('currency'),
                'payment_info' => null,
            ],
            'status' => Status::INITIATED->value
        ];
    }


    /**
     * @param array $data
     * @return Deposit
     */
    public function save(array $data): Deposit
    {
        return Deposit::create($data);
    }


    /**
     * @param string|int $id
     * @return Deposit|null
     */
    public function findById(string|int $id): ?Deposit
    {
        return Deposit::find($id);
    }

    /**
     * @param string $trx
     * @return Deposit|null
     */
    public function findByTrxId(string $trx): ?Deposit
    {
        return Deposit::where('trx', $trx)
            ->where(function ($query) {
                $query->where('status', Status::INITIATED->value)
                    ->orWhere('status', Status::PENDING->value);
            })->first();
    }


    public function getUserDepositByPaginated(int $userId, array $with = [], int $status = null): AbstractPaginator
    {
        $query =  Deposit::query()
            ->filter(request()->all())
            ->where('user_id', $userId)
            ->with($with)
            ->latest('id');

        if (!is_null($status)) {
            $query->where('status', '!=', $status);
        }

        return $query->paginate(getPaginate());
    }


    /**
     * @param array $with
     * @return AbstractPaginator
     */
    public function getDeposit(array $with = []): AbstractPaginator
    {
        $query = Deposit::filter(request()->all())->latest();

        if (!empty($with)) {
            $query->with($with);
        }

        return $query->paginate(getPaginate());
    }


    /**
     * @param int|string|null $userId
     * @return array
     */
    public function getReport(int|string $userId = null): array
    {
        $query = Deposit::query();

        if(!is_null($userId)){
            $query->where('user_id', $userId);
        }

        $deposit = $query->select(
            DB::raw('SUM(amount) as total'),
            DB::raw('SUM(CASE WHEN wallet_type = ' . WalletType::PRIMARY->value . ' THEN amount ELSE 0 END) as primary_amount'),
            DB::raw('SUM(CASE WHEN wallet_type = ' . WalletType::INVESTMENT->value . ' THEN amount ELSE 0 END) as investment_amount'),
            DB::raw('SUM(CASE WHEN wallet_type = ' . WalletType::TRADE->value . ' THEN amount ELSE 0 END) as trade_amount')
        )->where('status', \App\Enums\Payment\Deposit\Status::SUCCESS->value)->first();

        return  [
            'total' => is_null($deposit->total) ? 0 : $deposit->total,
            'primary' => [
                'amount' => is_null($deposit->primary_amount) ? 0 : $deposit->primary_amount,
                'percentage' => ($deposit->total != 0) ? ($deposit->primary_amount / $deposit->total) * 100 : 0,
            ],
            'investment' => [
                'amount' => is_null($deposit->investment_amount) ? 0 : $deposit->investment_amount,
                'percentage' => ($deposit->total != 0) ? ($deposit->investment_amount / $deposit->total) * 100 : 0,
            ],
            'trade' => [
                'amount' => is_null($deposit->trade_amount) ? 0 : $deposit->trade_amount,
                'percentage' => ($deposit->total != 0) ? ($deposit->trade_amount / $deposit->total) * 100 : 0,
            ],
        ];
    }

    public function monthlyReport(int|string $userId = null): array
    {
        $report = [
            'months' => collect(),
            'deposit_month_amount' => collect(),
            'withdraw_month_amount' => collect(),
        ];

        $startOfLast12Months = Carbon::now()->subMonths(11)->startOfMonth();

        $depositsMonth = Deposit::where('created_at', '>=', $startOfLast12Months)
            ->where('status', \App\Enums\Payment\Deposit\Status::SUCCESS->value)
            ->when(!is_null($userId), fn ($query) => $query->where('user_id', $userId))
            ->selectRaw("DATE_FORMAT(created_at,'%M-%Y') as months, SUM(amount) as depositAmount")
            ->groupBy('months')
            ->get();

        $withdrawMonth = WithdrawLog::where('created_at', '>=', $startOfLast12Months)
            ->where('status', \App\Enums\Payment\Withdraw\Status::SUCCESS->value)
            ->when(!is_null($userId), fn ($query) => $query->where('user_id', $userId))
            ->selectRaw("DATE_FORMAT(created_at,'%M-%Y') as months, SUM(amount) as withdrawAmount")
            ->groupBy('months')
            ->get();

        $last12Months = collect(CarbonPeriod::create($startOfLast12Months, '1 month', Carbon::now()->endOfMonth()))
            ->map(function ($date) {
                return $date->format('F-Y');
            });

        $last12Months->each(function ($month) use (&$report, $depositsMonth) {
            $depositDataForMonth = $depositsMonth->firstWhere('months', $month);

            $report['months']->push($month);
            $report['deposit_month_amount']->push(getAmount(optional($depositDataForMonth)->depositAmount));
        });

        $last12Months->each(function ($month) use (&$report, $withdrawMonth) {
            $withdrawDataForMonth = $withdrawMonth->firstWhere('months', $month);

            $report['withdraw_month_amount']->push(getAmount(optional($withdrawDataForMonth)->withdrawAmount));
        });

        return [
            $report['months']->values()->all(),
            $report['deposit_month_amount']->values()->all(),
            $report['withdraw_month_amount']->values()->all(),
        ];
    }


    /**
     * @param float|int $amount
     * @param int|string|null $userId
     * @return array
     */
    public function depositPrepParams(float|int $amount, int|string $userId = null): array
    {
        return [
            'user_id' => is_null($userId) ? Auth::id() : $userId,
            'payment_gateway_id' => 0,
            'rate' => 1,
            'amount' => $amount,
            'final_amount' => $amount,
            'charge' => $amount,
            'trx' => getTrx(),
            'status' => \App\Enums\Payment\Deposit\Status::SUCCESS->value
        ];
    }

}
