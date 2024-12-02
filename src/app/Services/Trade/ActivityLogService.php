<?php

namespace App\Services\Trade;

use App\Enums\Trade\TradeOutcome;
use App\Enums\Trade\TradeParameterUnit;
use App\Enums\Trade\TradeStatus;
use App\Enums\Trade\TradeType;
use App\Enums\Trade\TradeVolume;
use App\Enums\Transaction\Source;
use App\Enums\Transaction\Type;
use App\Enums\Transaction\WalletType;
use App\Models\CryptoCurrency;
use App\Models\TradeLog;
use App\Models\TradeParameter;
use App\Models\Wallet;
use App\Services\Api\CoinGeckoService;
use App\Services\Payment\WalletService;
use App\Services\SettingService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ActivityLogService
{
    public function __construct(
        protected WalletService $walletService,
        protected CoinGeckoService $coinGeckoService,
    ){
    }

    /**
     * @param TradeType $tradeType
     * @param int|string|null $cryptoId
     * @param int|string|null $userId
     * @param array $with
     * @return AbstractPaginator
     */
    public function getByPaginate(TradeType $tradeType, int|string $cryptoId = null, int|string $userId = null, array $with = []): AbstractPaginator
    {
        $query = TradeLog::filter(request()->all())
            ->where('type', $tradeType->value);

        if (!is_null($cryptoId)) {
            $query->where('crypto_currency_id', $cryptoId);
        }

        if (!empty($with)) {
            $query->with($with);
        }

        if (!is_null($userId)) {
            $query->where('user_id', $userId);
        }

        return $query->paginate(getPaginate());
    }



    public function getDuration(TradeParameter $tradeParameter): float|int
    {
        return match ($tradeParameter->unit ?? null) {
            TradeParameterUnit::MINUTES->value => $tradeParameter->time * 60,
            TradeParameterUnit::HOURS->value => $tradeParameter->time * 3600,
            default => $tradeParameter->time,
        };
    }

    /**
     * @param Request $request
     * @param TradeParameter $tradeParameter
     * @param CryptoCurrency $cryptoCurrency
     * @return array
     */
    public function prepParams(Request $request, TradeParameter $tradeParameter, CryptoCurrency $cryptoCurrency): array
    {
        return [
            'user_id' => Auth::id(),
            'crypto_currency_id' => $cryptoCurrency->id,
            'original_price' => getCryptoPrice($cryptoCurrency->symbol),
            'amount' => $request->input('amount'),
            'duration' => $this->getDuration($tradeParameter),
            'arrival_time' => Carbon::now()->addSeconds($this->getDuration($tradeParameter)),
            'type' => $request->input('type'),
            'volume' => $request->input('volume'),
            'outcome' => TradeOutcome::INITIATED->value,
            'status' => TradeStatus::RUNNING->value,
            'meta' => null,
        ];
    }

    /**
     * @param array $params
     * @return TradeLog
     */
    public function save(array $params): TradeLog
    {
        return TradeLog::create($params);
    }

    /**
     * @param Request $request
     * @param Wallet $wallet
     * @param array $account
     * @param Type $type
     * @param TradeParameter $tradeParameter
     * @param CryptoCurrency $cryptoCurrency
     * @return void
     */
    public function executeTrade(Request $request, Wallet $wallet, array $account, Type $type, TradeParameter $tradeParameter, CryptoCurrency $cryptoCurrency): void
    {
        DB::transaction(function () use ($request, $wallet, $account, $type, $tradeParameter, $cryptoCurrency) {
            $trade = $this->save($this->prepParams($request, $tradeParameter, $cryptoCurrency));
            $details = 'Trade BTC '.TradeVolume::getName($trade->volume).' at '.getCurrencySymbol().$trade->amount;
            $this->updateTradeBalance($wallet, $account, $trade, $type, $details);
        });
    }


    /**
     * @param Wallet $wallet
     * @param array $account
     * @param TradeLog $tradeLog
     * @param Type $type
     * @param $details
     * @param int $result
     * @return void
     */
    public function updateTradeBalance(Wallet $wallet, array $account, TradeLog $tradeLog, Type $type, $details, int $result = 55): void
    {
        $tradeAmount = $tradeLog->amount;
        if($result == TradeOutcome::WIN->value){
            $tradeAmount = $this->tradeWinCalculate($tradeLog);
        }

        $amount = $type->value == Type::MINUS->value ? -$tradeLog->amount : $tradeAmount;
        $name = Arr::get($account, 'name', 'practice_balance');

        $wallet->$name += $amount;
        $wallet->save();

        if($type->value == Type::PLUS->value && $result == TradeOutcome::WIN->value){
            $tradeLog->winning_amount = $this->tradeWinCalculate($tradeLog) - $tradeLog->amount;
            $tradeLog->save();
        }

        $account = $this->walletService->findBalanceByWalletType(WalletType::TRADE->value, $wallet);
        if($tradeLog->type == TradeType::TRADE->value){
            $this->walletService->updateTransaction(
                $tradeLog->user_id,
                $type->value == Type::MINUS->value ? $tradeLog->amount : $tradeAmount,
                $type,
                Source::TRADE,
                $account,
                $details
            );
        }
    }


    /**
     * @throws GuzzleException
     */
    public function cron(): void
    {
        $tradeLogs = TradeLog::where('outcome', TradeOutcome::INITIATED->value)
            ->where('status',TradeStatus::RUNNING->value)
            ->where('arrival_time', '<', Carbon::now())
            ->get();


        foreach ($tradeLogs as $tradeLog){
            $this->result($tradeLog);
        }
    }


    /**
     * @param TradeLog $tradeLog
     * @return void
     */
    public function result(TradeLog $tradeLog): void
    {
        $currentCryptoRate = getCryptoPrice($tradeLog->cryptoCurrency->symbol);
        $result = $this->determineTradeOutcome($tradeLog, $currentCryptoRate);
        [$balance, $details] = $this->tradeCalculate($tradeLog, $result);

        if ($balance > 0) {
            $wallet = $tradeLog?->user?->wallet;
            $walletType = $tradeLog->type == TradeType::TRADE->value ? WalletType::TRADE->value : WalletType::PRACTICE->value;
            $account = $this->walletService->findBalanceByWalletType($walletType, $wallet);
            $this->updateTradeBalance($wallet, $account, $tradeLog, Type::PLUS, $details, $result);
        }

        $tradeLog->outcome = $result;
        $tradeLog->status = TradeStatus::COMPLETE->value;
        $tradeLog->meta = [
            'result_price' => $currentCryptoRate,
        ];
        $tradeLog->save();
    }

    private function determineTradeOutcome(TradeLog $tradeLog, float $currentCryptoRate): int
    {
        return match (true) {
            $tradeLog->volume == TradeVolume::HIGH->value && $tradeLog->original_price < $currentCryptoRate,
                $tradeLog->volume == TradeVolume::LOW->value && $tradeLog->original_price > $currentCryptoRate => TradeOutcome::WIN->value,
            $tradeLog->volume == TradeVolume::HIGH->value && $tradeLog->original_price > $currentCryptoRate,
                $tradeLog->volume == TradeVolume::LOW->value && $tradeLog->original_price < $currentCryptoRate => TradeOutcome::LOSE->value,
            default => TradeOutcome::DRAW->value,
        };
    }


    /**
     * @param TradeLog $tradeLog
     * @param int $result
     * @return array
     */
    private function tradeCalculate(TradeLog $tradeLog, int $result): array
    {
        $setting = SettingService::getSetting();
        $tradeAmount = calculateCommissionPlus($tradeLog->amount, getArrayValue($setting->commissions_charge, 'binary_trade_commissions', 0));

        return match ($result) {
            TradeOutcome::WIN->value => [$tradeAmount, "Trade {$tradeLog->symbol} WIN"],
            TradeOutcome::DRAW->value => [$tradeLog->amount, "Trade {$tradeLog->symbol} Refund"],
            default => [0, ''],
        };
    }


    /**
     * @param TradeLog $tradeLog
     * @return float|int|string
     */
    private function tradeWinCalculate(TradeLog $tradeLog): float|int|string
    {
        $setting = SettingService::getSetting();
        return calculateCommissionPlus($tradeLog->amount, getArrayValue($setting->commissions_charge, 'binary_trade_commissions', 0));
    }


    public function getByUser(int $userId, TradeType $tradeType, bool $isLimit = false): AbstractPaginator|Collection
    {
        $query = TradeLog::filter(request()->all())
            ->where('user_id', $userId)
            ->where('type', $tradeType->value)
            ->with('cryptoCurrency')
            ->orderBy('id', 'DESC');

        if ($isLimit) {
            return $query->take(10)->get();
        } else {
            return $query->paginate(getPaginate());
        }
    }


    public function recentActivities(TradeType $tradeType, int $limit = 10, array $with = []): Collection
    {
        $query =  TradeLog::where('type', $tradeType->value)
            ->orderBy('id', 'DESC')
            ->take($limit);

        if(!empty($with)){
            $query->with($with);
        }

        return $query->get();
    }


    /**
     * @param int|string|null $userId
     * @return array
     */
    public function dayReport(int|string $userId = null): array
    {
        $report = [
            'days' => collect(),
            'trade_day_amount' => collect(),
        ];

        $startOfLast90Days = Carbon::now()->subDays(89)->startOfDay();

        $investmentsDay = TradeLog::where('created_at', '>=', $startOfLast90Days)
            ->when(!is_null($userId), fn ($query) => $query->where('user_id', $userId))
            ->selectRaw("DATE_FORMAT(created_at,'%Y-%m-%d') as days, SUM(amount) as amount")
            ->orderBy('created_at')
            ->groupBy('days', 'amount', 'created_at')
            ->get();

        $last90Days = collect(CarbonPeriod::create($startOfLast90Days, '1 day', Carbon::now()->endOfDay()))
            ->map(function ($date) {
                return $date->format('Y-m-d');
            });

        $last90Days->each(function ($day) use (&$report, $investmentsDay) {
            $investmentDataForDay = $investmentsDay->firstWhere('days', $day);

            $report['days']->push($day);
            $report['trade_day_amount']->push(getAmount(optional($investmentDataForDay)->amount));
        });

        return [
            $report['days']->values()->all(),
            $report['trade_day_amount']->values()->all(),
        ];
    }


    /**
     * @param int|string|null $userId
     * @return Builder|Model|object|null
     */
    public function getTradeReport(int|string $userId = null)
    {
        $completeStatus = TradeStatus::COMPLETE->value;
        $query = TradeLog::query();

        if (!is_null($userId)) {
            $query->where('user_id', $userId);
        }

        return $query->selectRaw('
            COALESCE(SUM(CASE WHEN status = ? THEN amount ELSE 0 END), 0) as total,
            COALESCE(SUM(CASE WHEN DATE(created_at) = CURDATE() THEN amount ELSE 0 END), 0) as today,
            COALESCE(SUM(CASE WHEN outcome = ? AND status = ? THEN amount ELSE 0 END), 0) as wining,
            COALESCE(SUM(CASE WHEN outcome = ? AND status = ? THEN amount ELSE 0 END), 0) as loss,
            COALESCE(SUM(CASE WHEN outcome = ? AND status = ? THEN amount ELSE 0 END), 0) as draw,
            COALESCE(SUM(CASE WHEN volume = ? AND status = ? THEN amount ELSE 0 END), 0) as high,
            COALESCE(SUM(CASE WHEN volume = ? AND status = ? THEN amount ELSE 0 END), 0) as low',
            [
                $completeStatus, TradeOutcome::WIN->value, $completeStatus,
                TradeOutcome::LOSE->value, $completeStatus, TradeOutcome::DRAW->value, $completeStatus,
                TradeVolume::HIGH->value, $completeStatus, TradeVolume::LOW->value, $completeStatus,
            ])->first();
    }



}
