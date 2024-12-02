<?php

namespace App\Actions;

use App\Enums\CommissionType;
use App\Enums\Email\EmailSmsTemplateName;
use App\Enums\Referral\ReferralCommissionType;
use App\Enums\Status;
use App\Enums\Transaction\Source;
use App\Enums\Transaction\Type;
use App\Enums\Transaction\WalletType;
use App\Jobs\EmailSmsProcessJob;
use App\Models\Holiday;
use App\Models\InvestmentLog;
use App\Models\Referral;
use App\Models\User;
use App\Services\Investment\CommissionService;
use App\Services\Payment\TransactionService;
use App\Services\Payment\WalletService;
use App\Services\SettingService;
use Carbon\Carbon;

class InvestmentHandler
{
    /**
     * Get the next working day of the system
     *
     * @param integer $hours
     * @return string
     */
    public static function nextWorkingDay(int $hours): string
    {
        $now = now();
        while (true) {
            $nextPossible = Carbon::parse($now)->addHours($hours)->toDateTimeString();
            if (!self::isHoliday($nextPossible)) {
                $next = $nextPossible;
                break;
            }

            $now = $now->addDay();
        }

        return $next;
    }

    public static function capitalReturn(InvestmentLog $investmentLog): void
    {
        $user = $investmentLog->user;
        $wallet = $user->wallet->fresh();
        $wallet->investment_balance += $investmentLog->amount;
        $wallet->save();

        $trx = getTrx();
        $transactionService = resolve(TransactionService::class);
        $walletService = resolve(WalletService::class);

        $transactionParams = [
            'user_id' => (int) $user->id,
            'amount' => $investmentLog->amount,
            'type' => Type::PLUS,
            'trx' => $trx,
            'details' => getCurrencySymbol() . shortAmount($investmentLog->amount) . ' ' . ' capital back from ' . $investmentLog->plan_name,
            'wallet' => $walletService->findBalanceByWalletType(WalletType::INVESTMENT->value, $wallet),
            'source' => Source::INVESTMENT->value,
        ];

        $transactionService->save($transactionService->prepParams($transactionParams));
    }


    public static function isHoliday(string $date): bool
    {
        $setting = SettingService::getSetting();
        $isHoliday = true;
        $holidayCount = Holiday::where('date', date('Y-m-d', strtotime($date)))->count();
        $day = strtolower(date('l'));
        $holiday = (array) $setting->holiday_setting;

        if (!in_array($day, $holiday) && $holidayCount == 0) {
            $isHoliday = false;;
        }

        return $isHoliday;
    }


    public static function processReferralCommission(User $user, float|string $amount, ReferralCommissionType $referralCommissionType, string $trx): void
    {
        $setting = SettingService::getSetting();
        $commissionName = ReferralCommissionType::getName($referralCommissionType->value);
        $commissionSetting = getArrayValue($setting->referral_setting, ReferralCommissionType::getColumnName($referralCommissionType->value));
        if ($commissionSetting != Status::ACTIVE->value){
            return;
        }

        $i = 1;
        $level = Referral::where('commission_type', $referralCommissionType->value)->count();

        while ($i <= $level) {
            $referral = $user->referredBy;
            if ($referral == null) {
                break;
            }

            $commission = Referral::where('commission_type', $referralCommissionType->value)->where('level', $i)->first();
            if (!$commission) {
                break;
            }

            $commissionAmount = ($amount * $commission->percent) / 100;
            $wallet = $referral->wallet->fresh();

            if ($referralCommissionType->value == ReferralCommissionType::DEPOSIT->value){
                $wallet->primary_balance += $commissionAmount;
                $walletType = WalletType::PRIMARY->value;
                $source = Source::ALL;
                $commissionType = CommissionType::DEPOSIT;
            }else{
                $wallet->investment_balance += $commissionAmount;
                $walletType = WalletType::INVESTMENT->value;
                $source = Source::INVESTMENT;
                $commissionType = CommissionType::INVESTMENT;
            }
            $wallet->save();

            $transaction = resolve(TransactionService::class);
            $walletService = resolve(WalletService::class);
            $commissionService = resolve(CommissionService::class);
            $details = ' Level ' . $i . ' Referral ' .$commissionName.' From ' . $user->email;

            $transaction->save($transaction->prepParams([
                'user_id' => $referral->id,
                'amount' => $commissionAmount,
                'type' => Type::PLUS,
                'details' => $details,
                'trx' => $trx,
                'wallet' => $walletService->findBalanceByWalletType($walletType, $wallet),
                'source' => $source
            ]));

            $commissionService->save($commissionService->prepParams($referral->id, $details, $commissionType, $commissionAmount, $user->id));

            dispatch(new EmailSmsProcessJob($referral, [
                'amount' => shortAmount($amount),
                'currency' => getCurrencySymbol(),
            ], EmailSmsTemplateName::REFERRAL_COMMISSION->value));

            $user = $referral;
            $i++;
        }
    }

}
