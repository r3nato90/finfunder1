<?php

namespace App\Services\Investment;

use App\Actions\MatrixHandler;
use App\Enums\Matrix\InvestmentStatus;
use App\Enums\Transaction\Source;
use App\Enums\Transaction\Type;
use App\Enums\Transaction\WalletType;
use App\Models\MatrixInvestment;
use App\Models\Matrix;
use App\Models\User;
use App\Notifications\MatrixInvestmentNotification;
use App\Services\Payment\TransactionService;
use App\Services\Payment\WalletService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MatrixInvestmentService
{
    public function __construct(
        protected TransactionService $transactionService,
        protected WalletService $walletService,
    )
    {

    }

    /**
     * @param Matrix $matrix
     * @param int $userId
     * @return array
     */
    public function prepParams(Matrix $matrix, int $userId): array
    {
        $level = [
            'matrix_levels' => array_map(fn($item) => [
                'level' => $item['level'],
                'amount' => getAmount($item['amount']),
            ], $matrix->matrixLevel->toArray()),
        ];

        return [
            'uid' => Str::random(),
            'user_id' => $userId,
            'plan_id' => $matrix->id,
            'name' => $matrix->name,
            'trx' => getTrx(),
            'price' => $matrix->amount,
            'referral_reward' => $matrix->referral_reward,
            'meta' => $level,
            'status' => InvestmentStatus::RUNNING->value,
        ];
    }

    /**
     * @param array $params
     * @return MatrixInvestment
     */
    public function save(array $params): MatrixInvestment
    {
        return MatrixInvestment::create($params);
    }

    /**
     * @param Request $request
     * @param Matrix $matrix
     * @param User $user
     * @return void
     */
    public function executeEnrolledScheme(Request $request, Matrix $matrix, User $user): void
    {
        DB::transaction(function () use ($request, $matrix, $user) {
            $matrixHandler = new MatrixHandler($user, $matrix);
            $matrixHandler->store();

            $invest = $this->save($this->prepParams($matrix, (int)$user->id));
            $invest->notify(new MatrixInvestmentNotification());

            $wallet = $user->wallet;
            $wallet->primary_balance -= $matrix->amount;
            $wallet->save();

            $this->transactionService->save($this->transactionService->prepParams([
                'user_id' => (int)$user->id,
                'amount' => $matrix->amount,
                'type' => Type::MINUS,
                'trx' => getTrx(),
                'details' => "Enrollment in the {$matrix->name} Matrix plan.",
                'wallet' => $this->walletService->findBalanceByWalletType(WalletType::PRIMARY->value, $wallet),
                'source' => Source::INVESTMENT->value
            ]));
        });
    }

    /**
     * @param int $userId
     * @return MatrixInvestment|null
     */
    public function findByUserId(int $userId): ?MatrixInvestment
    {
        return MatrixInvestment::where('user_id', $userId)->first();
    }

    /**
     * @return AbstractPaginator
     */
    public function getEnrolledByPaginate(): AbstractPaginator
    {
        return MatrixInvestment::filter(request()->all())
            ->with(['user'])
            ->paginate(getPaginate());
    }


    public function latestMatrix(array $with = [], int $limit = 5): Collection
    {
        return  MatrixInvestment::query()
            ->with($with)
            ->latest('id')
            ->take($limit)->get();
    }

    public function getMatrixReport(int|string $userId = null)
    {
        $now = now()->toDateString();
        $query = MatrixInvestment::query();

        if (!is_null($userId)) {
            $query->where('user_id', $userId);
        }

        return $query->selectRaw('
        COALESCE(SUM(price), 0) as total,
        COALESCE(SUM(CASE WHEN DATE(created_at) = ? THEN price ELSE 0 END), 0) as today,
        COALESCE(SUM(referral_commissions), 0) as referral,
        COALESCE(SUM(level_commissions), 0) as level,
        COALESCE(SUM(level_commissions + referral_commissions), 0) as commission
    ', [$now])->first();
    }

    /**
     * @return array
     */
    public function monthlyReport(): array
    {
        $report = [
            'months' => collect(),
            'invest_month_amount' => collect(),
        ];

        $startOfLast12Months = Carbon::now()->subMonths(11)->startOfMonth();

        $logs = MatrixInvestment::where('created_at', '>=', $startOfLast12Months)
            ->selectRaw("DATE_FORMAT(created_at, '%M-%Y') as months, SUM(price) as invest_amount")
            ->orderBy('months')
            ->groupBy('months')
            ->get();

        $last12Months = collect(CarbonPeriod::create($startOfLast12Months, '1 month', Carbon::now()->endOfMonth()))
            ->map(function ($date) {
                return $date->format('F-Y');
            });

        $last12Months->each(function ($month) use (&$report, $logs) {
            $logDataForMonth = $logs->firstWhere('months', $month);

            $report['months']->push($month);
            $report['invest_month_amount']->push(optional($logDataForMonth)->invest_amount ?? 0);
        });

        return [
            $report['months']->values()->all(),
            $report['invest_month_amount']->values()->all(),
        ];

    }



}


