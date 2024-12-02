<?php

namespace App\Http\Controllers;

use App\Enums\CommissionType;
use App\Enums\CronCode;
use App\Enums\Status;
use App\Enums\Transaction\Source;
use App\Enums\Transaction\Type;
use App\Enums\Transaction\WalletType;
use App\Models\Agent;
use App\Models\AgentTransaction;
use App\Models\Cron;
use App\Models\InvestmentUserReward;
use App\Models\User;
use App\Services\Api\CoinGeckoService;
use App\Services\Investment\CommissionService;
use App\Services\Investment\InvestmentService;
use App\Services\Investment\Staking\StakingInvestmentService;
use App\Services\Payment\TransactionService;
use App\Services\Payment\WalletService;
use App\Services\SettingService;
use App\Services\Trade\ActivityLogService;
use App\Services\Trade\CryptoCurrencyService;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;

class CronController extends Controller
{
    public function __construct(
        protected ActivityLogService $activityLogService,
        protected InvestmentService $investmentService,
        protected CryptoCurrencyService $cryptoCurrencyService,
        protected CoinGeckoService $coinGeckoService,
        protected StakingInvestmentService $stakingInvestmentService,
        protected TransactionService $transactionService,
        protected WalletService $walletService,
        protected CommissionService $commissionService,
    )
    {

    }

    /**
     * @throws GuzzleException
     */
    public function handle(): void
    {
        $cron = Cron::all();
        foreach ($cron as $value) {
            if ($value->code == CronCode::CRYPTO_CURRENCY->value &&
                ($value->last_run === null || Carbon::parse($value->last_run)->addDay()->isPast())) {
                $this->cryptoSave();
                $value->last_run = Carbon::now();
            }

            if ($value->code == CronCode::INVESTMENT_PROCESS->value || $value->code == CronCode::TRADE_OUTCOME->value){
                $value->last_run = Carbon::now();
            }

            $value->save();
        }

        $this->investmentService->cron();
        $this->stakingInvestmentService->cron();
        $this->activityLogService->cron();
        $this->investmentReward();
        $this->agentMonthlyInvestment();
    }

    /**
     * @throws GuzzleException
     */
    protected function cryptoSave(): void
    {
        $topCryptoCurrencies = $this->coinGeckoService->getTopCryptoCurrencies(100);
        if(!is_null($topCryptoCurrencies)){
            foreach ($topCryptoCurrencies as $value){
                $this->cryptoCurrencyService->save($this->cryptoCurrencyService->prepParams($value));
            }
        }
    }

    public function investmentReward(): void
    {
        $setting = SettingService::getSetting();
        if (getArrayValue($setting->system_configuration, 'investment_reward.value') != Status::ACTIVE->value) {
            return;
        }

        $rewardUsers = User::with('referredUsers', 'ongoingReferrals')
            ->orderBy('last_reward_update')
            ->limit(100)
            ->get();

        foreach ($rewardUsers as $user) {
            $user->last_reward_update = now();
            $user->save();

            $referralCount   = $user->ongoingReferrals->count();
            $depositAmount = $user->deposit->sum('final_amount');
            $aggregateInvestment = $user->aggregate_investment;
            $collectiveInvestment = $user->collective_investment;

            $rewards = InvestmentUserReward::where('status', Status::ACTIVE->value)
                ->where('id', '>', $user->reward_identifier)
                ->where('invest', '<=', $aggregateInvestment)
                ->where('team_invest', '<=', $collectiveInvestment)
                ->where('deposit', '<=', $depositAmount)
                ->where('referral_count', '<=', $referralCount)
                ->get();


            foreach ($rewards as $investmentReward) {
                $user->reward_identifier = $investmentReward->id;
                $user->save();

                $wallet = $user->wallet->fresh();
                $wallet->investment_balance += $investmentReward->reward;
                $wallet->save();

                $transactionParams = [
                    'user_id' => (int) $user->id,
                    'amount' => $investmentReward->reward,
                    'type' => Type::PLUS,
                    'trx' => getTrx(),
                    'details' => shortAmount($investmentReward->reward) . ' ' . getCurrencyName() . ' investment reward for ' . @$investmentReward->name,
                    'wallet' => $this->walletService->findBalanceByWalletType(WalletType::INVESTMENT->value, $wallet),
                    'source' => Source::INVESTMENT->value,
                ];

                $this->transactionService->save($this->transactionService->prepParams($transactionParams));
                $this->commissionService->save($this->commissionService->prepParams(
                    $user->id,
                    shortAmount($investmentReward->reward) . ' ' . getCurrencyName() . ' investment reward for ' . @$investmentReward->name,
                    CommissionType::INVESTMENT,
                    $investmentReward->reward,
                ));
            }
        }
    }


    public function agentMonthlyInvestment(): void
    {
        $currentDate = Carbon::now();
        $lastDayOfMonth = $currentDate->copy()->endOfMonth();

        if (!$currentDate->isSameDay($lastDayOfMonth)) {
            return;
        }

        $setting = SettingService::getSetting();
        if (getArrayValue($setting->agent_investment_commission, 'monthly_team_investment_commission.status') == \App\Enums\Status::ACTIVE->value) {
            $bonus = getArrayValue($setting->agent_investment_commission, 'monthly_team_investment_commission.bonus');
            $monthlyTeamInvestment = getArrayValue($setting->agent_investment_commission, 'monthly_team_investment_commission.monthly_team_investment');
            $monthYear = $currentDate->format('F Y');

            // Fetch active agents with balance and monthly investment
            $agents = Agent::where('status', Status::ACTIVE->value)
                ->select('id', 'balance', 'monthly_investment')
                ->get();

            foreach ($agents as $agent) {
                // Check if the agent's monthly investment meets the required threshold
                if ($agent->monthly_investment >= $monthlyTeamInvestment) {
                    $agent->balance += $bonus;
                    $agent->monthly_investment += 0;
                    $agent->save();

                    // Record the transaction with the month included
                    $agentTransaction = new AgentTransaction();
                    $agentTransaction->agent_id = $agent->id;
                    $agentTransaction->amount = $bonus;
                    $agentTransaction->post_balance = $agent->balance;
                    $agentTransaction->trx = getTrx();
                    $agentTransaction->type = Type::PLUS->value;
                    $agentTransaction->details = "Commission for investment log for $monthYear";
                    $agentTransaction->save();
                }
            }
        }
    }
}
