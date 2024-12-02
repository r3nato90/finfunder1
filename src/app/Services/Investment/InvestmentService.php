<?php

namespace App\Services\Investment;

use App\Actions\InvestmentHandler;
use App\Enums\CommissionType;
use App\Enums\Investment\InterestType;
use App\Enums\Investment\Recapture;
use App\Enums\Investment\ReturnType;
use App\Enums\Investment\Status;
use App\Enums\Payment\NotificationType;
use App\Enums\Referral\ReferralCommissionType;
use App\Enums\Transaction\Source;
use App\Enums\Transaction\Type;
use App\Enums\Transaction\WalletType;
use App\Models\AgentTransaction;
use App\Models\InvestmentLog;
use App\Models\InvestmentPlan;
use App\Models\User;
use App\Models\Wallet;
use App\Notifications\InvestmentLogNotification;
use App\Services\Payment\TransactionService;
use App\Services\Payment\WalletService;
use App\Services\SettingService;
use App\Services\UserService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InvestmentService
{
    public function __construct(
        protected WalletService $walletService,
        protected TransactionService $transactionService,
        protected CommissionService $commissionService,
    )
    {

    }

    /**
     * @param int|string $id
     * @return InvestmentLog|null
     */
    public function findById(int|string $id): ?InvestmentLog
    {
        return InvestmentLog::where('id', $id)->first();
    }


    public function findByUid(string $uid): ?InvestmentLog
    {
        return InvestmentLog::where('uid', $uid)->first();
    }


    /**
     * @param array $with
     * @param int|string|null $planId
     * @param int|string|null $userId
     * @return AbstractPaginator
     */
    public function getInvestmentLogsByPaginate(array $with = [], int|string $planId = null, int|string $userId = null): AbstractPaginator
    {
        $query =  InvestmentLog::filter(request()->all());

        if(!is_null($planId)){
            $query->where('investment_plan_id', $planId);
        }

        if(!is_null($userId)){
            $query->where('user_id', $userId);
        }

        if(!empty($with)){
            $query->with($with);
        }

        return $query->orderBy('id', 'DESC')
            ->paginate(getPaginate());
    }


    /**
     * @param int $userId
     * @param int $investmentId
     * @param Status $status
     * @return InvestmentLog|null
     */
    public function findCurrentInvestmentLog(int $userId, int $investmentId, Status $status): ?InvestmentLog
    {
        return InvestmentLog::where('status', $status->value)
            ->where('investment_plan_id', $investmentId)
            ->where('user_id', $userId)
            ->first();
    }


    /**
     * @param int|string|float $amount
     * @param InvestmentPlan $investmentPlan
     * @return array
     */
    public function prepParams(int|string|float $amount, InvestmentPlan $investmentPlan): array
    {
        $period = ($investmentPlan->interest_return_type == ReturnType::LIFETIME->value) ? 0 : $investmentPlan->duration;
        $interestAmount = $investmentPlan->interest_rate;

        if ($investmentPlan->interest_type == InterestType::PERCENT->value) {
            $interestAmount = ($amount * $investmentPlan->interest_rate) / 100;
        }

        $shouldPay = -1;

        if ($period > 0) {
            $shouldPay = $interestAmount * $period;
        }

        return [
            'uid' => Str::random(),
            'user_id' => Auth::id(),
            'investment_plan_id' => $investmentPlan->id,
            'plan_name' => $investmentPlan->name,
            'amount' => $amount,
            'interest_rate' => $interestAmount,
            'period' => $period,
            'time_table_name' => $investmentPlan->timeTable->name ?? 'Hours',
            'hours' => $investmentPlan->timeTable->time ?? 1,
            'profit_time' => InvestmentHandler::nextWorkingDay($investmentPlan->timeTable->time),
            'should_pay' => $shouldPay,
            'trx' => getTrx(),
            'recapture_type' => $investmentPlan->recapture_type,
            'status' => Status::INITIATED->value,
            'profit' => 0,
        ];
    }

    /**
     * @param array $investment
     * @return InvestmentLog
     */
    public function save(array $investment): InvestmentLog
    {
        return InvestmentLog::create($investment);
    }

    public function executeInvestment(int|float|string $amount, Wallet $wallet, InvestmentPlan $investmentPlan): void
    {
        DB::transaction(function () use ($wallet, $investmentPlan, $amount) {
            $wallet->primary_balance -= $amount;
            $wallet->save();

            $investmentLog = $this->save($this->prepParams($amount, $investmentPlan));
            $this->transactionService->save($this->transactionService->prepParams([
                'user_id' => Auth::id(),
                'amount' => $amount,
                'type' => Type::MINUS,
                'trx' => $investmentLog->trx,
                'details' => getCurrencySymbol().$amount.' invested in the '.$investmentPlan->name.' plan for a duration of ' .$investmentPlan->duration. ' days',
                'wallet' => $this->walletService->findBalanceByWalletType(WalletType::PRIMARY->value, $wallet),
                'source' => Source::INVESTMENT->value
            ]));

            InvestmentHandler::processReferralCommission($investmentLog->user,$amount,ReferralCommissionType::INVESTMENT,$investmentLog->trx);
            if($investmentLog->user->referral_by) {
                $user = User::find($investmentLog->user->referral_by);
                $user->collective_investment += $amount;
                $user->save();
            }

            $investmentLog->user->aggregate_investment += $amount;
            $investmentLog->user->save();

            $this->agentAggregateInvestment($investmentLog, Type::PLUS);
            $investmentLog->notify(new InvestmentLogNotification(NotificationType::REQUESTED));
        });
    }

    public function agentAggregateInvestment(InvestmentLog $investmentLog, Type $type)
    {
        $agent = $investmentLog->user->agent ?? null;
        if ($agent) {
            if ($type == Type::PLUS) {
                $agent->monthly_investment += $investmentLog->amount;
            } elseif ($type == Type::MINUS) {
                $agent->monthly_investment -= $investmentLog->amount;
            }
            $agent->save();
        }
    }


    /**
     * @param int|float|string $amount
     * @param InvestmentLog $investmentLog
     * @param Status $status
     * @param string $details
     * @param bool $isReInvest
     * @return void
     */
    public function investmentReturnAmount(int|float|string $amount, InvestmentLog $investmentLog, Status $status, string $details, bool $isReInvest = false): void
    {
        DB::transaction(function () use ($amount, $investmentLog, $status, $details, $isReInvest) {
            $user = $investmentLog->user;

            $wallet = $user->wallet;
            $wallet->investment_balance += $amount;
            $wallet->save();

            $this->transactionService->save($this->transactionService->prepParams([
                'user_id' => (int)$user->id,
                'amount' => $amount,
                'type' => Type::PLUS,
                'trx' => $investmentLog->trx,
                'details' => $details,
                'charge' => $investmentLog->amount - $amount,
                'wallet' => $this->walletService->findBalanceByWalletType(WalletType::INVESTMENT->value, $wallet),
                'source' => Source::INVESTMENT->value
            ]));

            $investmentLog->status = $status->value;
            $investmentLog->is_reinvest = $isReInvest;
            $investmentLog->save();

            if(!$isReInvest){
                if($investmentLog->user->referral_by) {
                    $user = User::find($investmentLog->user->referral_by);
                    $user->collective_investment -= $amount;
                    $user->save();
                }

                $investmentLog->user->aggregate_investment -= $amount;
                $investmentLog->user->save();

                $this->agentAggregateInvestment($investmentLog, Type::MINUS);
            }
        });
    }


    /**
     * @param int|string|null $userId
     * @return Builder|Model|object|null
     */
    public function getInvestmentReport(int|string $userId = null)
    {
        $query = InvestmentLog::query();

        if(!is_null($userId)){
            $query->where('user_id', $userId);
        }

        return $query->selectRaw('
            SUM(CASE WHEN DATE(created_at) = CURDATE() THEN amount ELSE 0 END) as today_invest,
            SUM(CASE WHEN DATE(profit_time) = CURDATE() THEN interest_rate ELSE 0 END) as payable,
            SUM(CASE WHEN status != ? THEN amount ELSE 0 END) as total,
            SUM(CASE WHEN status = ? THEN amount ELSE 0 END) as running,
            SUM(CASE WHEN status != ? THEN profit ELSE 0 END) as profit,
            SUM(CASE WHEN status = ? THEN amount ELSE 0 END) as closed,
            SUM(CASE WHEN is_reinvest = true THEN amount ELSE 0 END) as re_invest',
                [Status::CANCELLED->value, Status::INITIATED->value, Status::CANCELLED->value, Status::COMPLETED->value]
        )->first();
    }

    public function dayReport(): array
    {
        $report = [
            'days' => collect(),
            'investment_day_amount' => collect(),
        ];

        $startOfLast90Days = Carbon::now()->subDays(89)->startOfDay();

        $investmentsDay = InvestmentLog::where('created_at', '>=', $startOfLast90Days)
            ->whereIN('status', [Status::CANCELLED->value, Status::INITIATED->value, Status::COMPLETED->value])
            ->selectRaw("DATE_FORMAT(created_at,'%Y-%m-%d') as days, SUM(amount) as amount")
            ->groupBy('days')
            ->orderBy('days')
            ->get();

        $last90Days = collect(CarbonPeriod::create($startOfLast90Days, '1 day', Carbon::now()->endOfDay()))
            ->map(function ($date) {
                return $date->format('Y-m-d');
            });

        $last90Days->each(function ($day) use (&$report, $investmentsDay) {
            $investmentDataForDay = $investmentsDay->firstWhere('days', $day);

            $report['days']->push($day);
            $report['investment_day_amount']->push(getAmount(optional($investmentDataForDay)->amount));
        });

        return [
            $report['days']->values()->all(),
            $report['investment_day_amount']->values()->all(),
        ];
    }


    /**
     * @param int|string|null $userId
     * @return array
     */
    public function monthlyReport(int|string $userId = null): array
    {
        $report = [
            'months' => collect(),
            'invest_month_amount' => collect(),
            'profit_month_amount' => collect(),
        ];

        $startOfLast12Months = Carbon::now()->subMonths(11)->startOfMonth();

        $logs = InvestmentLog::where('created_at', '>=', $startOfLast12Months)
            ->where('status', Status::INITIATED->value)
            ->when(!is_null($userId), fn ($query) => $query->where('user_id', $userId))
            ->selectRaw("DATE_FORMAT(created_at,'%M-%Y') as months, SUM(amount) as invest_amount, SUM(profit) as profit_amount")
            ->groupBy('months')
            ->get();


        $last12Months = collect(CarbonPeriod::create($startOfLast12Months, '1 month', Carbon::now()->endOfMonth()))
            ->map(function ($date) {
                return $date->format('F-Y');
            });

        // Process data
        $last12Months->each(function ($month) use (&$report, $logs) {
            $logDataForMonth = $logs->firstWhere('months', $month);

            $report['months']->push($month);
            $report['invest_month_amount']->push(getAmount(optional($logDataForMonth)->invest_amount));
            $report['profit_month_amount']->push(getAmount(optional($logDataForMonth)->profit_amount));
        });

        return [
            $report['months']->values()->all(),
            $report['invest_month_amount']->values()->all(),
            $report['profit_month_amount']->values()->all(),
        ];
    }

    public function latestInvestments(array $with = [], int $limit = 5): Collection
    {
        return  InvestmentLog::query()
            ->with($with)
            ->latest('id')
            ->take($limit)->get();
    }


    public function cron(): void
    {
        $now = now()->toDateString();
        $setting = SettingService::getSetting();
        $day = strtolower(date('l'));
        $holiday = (array) $setting->holiday_setting;

        if (in_array($day, $holiday)) {
            exit;
        }

        try {
            $investmentLogs = InvestmentLog::with('plan.timeTable', 'user')
                ->where('status', Status::INITIATED->value)
                ->whereDate('profit_time','<=',$now)
                ->orderBy('last_time')
                ->take(100)
                ->get();

            foreach ($investmentLogs as $investmentLog) {
                $this->processProfit($investmentLog);
                if ($investmentLog->return_duration_count >= $investmentLog->period && $investmentLog->period != -1) {
                    $investmentLog->status = Status::COMPLETED->value;
                    if ($investmentLog->recapture_type == Recapture::YES->value ) {
                        InvestmentHandler::capitalReturn($investmentLog);
                    }elseif($investmentLog->recapture_type == Recapture::HOLD->value){
                        $investmentLog->status = Status::PROFIT_COMPLETED->value;
                    }

                    if($investmentLog->recapture_type != Recapture::HOLD->value) {
                        $this->agentCalculateCommission($investmentLog);
                    }
                    $investmentLog->save();
                }
            }
        } catch (\Exception $exception) {

        }
    }


    public function agentCalculateCommission(InvestmentLog $investmentLog)
    {
       try{
           if(is_null($investmentLog->user->agent_id)) {
               return;
           }

           $setting = SettingService::getSetting();
           $totalCommission = 0;

           // Fixed-based commission
           if (getArrayValue($setting->agent_investment_commission, 'fixed_commission.status') == \App\Enums\Status::ACTIVE->value) {
               $totalCommission += getArrayValue($setting->agent_investment_commission, 'fixed_commission.bonus');
           }

           // Percentage-based commission
           if (getArrayValue($setting->agent_investment_commission, 'percentage_commission.status') == \App\Enums\Status::ACTIVE->value) {
               $percentage = getArrayValue($setting->agent_investment_commission, 'percentage_commission.bonus');
               $totalCommission += ($investmentLog->amount * $percentage / 100);
           }

           // Performance-based commission
           if (getArrayValue($setting->agent_investment_commission, 'performance_based_commission.status') == \App\Enums\Status::ACTIVE->value) {
               $bonus = getArrayValue($setting->agent_investment_commission, 'performance_based_commission.bonus');
               $performanceThreshold = getArrayValue($setting->agent_investment_commission, 'performance_based_commission.threshold');

               if ($investmentLog->amount >= $performanceThreshold) {
                   $totalCommission += $bonus;
               }
           }

           $agent = $investmentLog->user->agent ?? null;
           if ($agent && $totalCommission > 0) {
               $agent->balance += $totalCommission;
               $agent->save();

               $agentTransaction = new AgentTransaction();
               $agentTransaction->agent_id = $agent->id;
               $agentTransaction->amount = $totalCommission;
               $agentTransaction->post_balance = $agent->balance;
               $agentTransaction->trx = getTrx();
               $agentTransaction->type = Type::PLUS->value;
               $agentTransaction->details = 'Commission for investment log Trx ' . $investmentLog->trx;
               $agentTransaction->save();
           }
       }catch (\Exception $exception){
           return null;
       }
    }

    private function processProfit(InvestmentLog $investmentLog): void
    {
        $user = $investmentLog->user;
        $investmentLog->return_duration_count += 1;
        $investmentLog->profit += $investmentLog->interest_rate;
        $investmentLog->should_pay -= $investmentLog->period > 0 ? $investmentLog->interest_rate : 0;
        $investmentLog->profit_time = InvestmentHandler::nextWorkingDay($investmentLog->plan->timeTable->time ?? 1);
        $investmentLog->last_time = now();
        $investmentLog->save();

        $wallet = $user->wallet->fresh();
        $wallet->investment_balance += $investmentLog->interest_rate;
        $wallet->save();

        $trx = getTrx();
        $transactionParams = [
            'user_id' => (int) $user->id,
            'amount' => $investmentLog->interest_rate,
            'type' => Type::PLUS,
            'trx' => $trx,
            'details' => "Investment {$investmentLog->plan_name} Plan as of ".now()->format('d M Y')." - Earnings: ".getCurrencySymbol().shortAmount($investmentLog->interest_rate),
            'wallet' => $this->walletService->findBalanceByWalletType(WalletType::INVESTMENT->value, $wallet),
            'source' => Source::INVESTMENT->value,
        ];

        InvestmentHandler::processReferralCommission($user,$investmentLog->interest_rate,ReferralCommissionType::INTEREST_RATE, $trx);
        $this->transactionService->save($this->transactionService->prepParams($transactionParams));
        $this->commissionService->save($this->commissionService->prepParams(
            $user->id,
            "Investment {$investmentLog->plan_name} Plan as of ".now()->format('d M Y')." - Earnings: ".getCurrencySymbol().shortAmount($investmentLog->interest_rate),
            CommissionType::INVESTMENT,
            $investmentLog->interest_rate,
            investmentLogId:$investmentLog->id
        ));
    }


    /**
     * @param User $investmentUser
     * @return void
     */
    public function ensureUserOwnership(User $investmentUser): void
    {
        abort_unless(Auth::id() == $investmentUser->id, 404);
    }


    /**
     * @param Request $request
     * @param Status $status
     * @return InvestmentLog|null
     */
    public function findValidInvestmentLog(Request $request, Status $status): ?InvestmentLog
    {
        $investmentLog = $this->findByUid($request->input('uid'));

        abort_unless($investmentLog && $investmentLog->status == $status->value && $investmentLog->profit == 0, 404);

        return $investmentLog;
    }
}
