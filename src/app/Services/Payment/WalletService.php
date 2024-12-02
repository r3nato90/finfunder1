<?php

namespace App\Services\Payment;

use App\Enums\Email\EmailSmsTemplateName;
use App\Enums\Transaction\Source;
use App\Enums\Transaction\Type;
use App\Enums\Transaction\WalletType;
use App\Jobs\EmailSmsProcessJob;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Services\SettingService;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WalletService
{

    public function __construct(
        protected TransactionService $transactionService,
    ){
    }
    /**
     * @param int $userId
     * @return array
     */
    public function prepParams(int $userId): array
    {
        return [
            'user_id' => $userId,
            'primary_balance' => 0,
            'investment_balance' => 0,
            'trade_balance' => 0,
            'practice_balance' => 100,
        ];
    }

    /**
     * @param array $data
     * @return Wallet
     */
    public function save(array $data): Wallet
    {
        return Wallet::create($data);
    }


    /**
     * @param int $type
     * @param Wallet $wallet
     * @return array|null
     */
    public function findBalanceByWalletType(int $type, Wallet $wallet): ?array
    {
        return match ($type) {
            WalletType::PRIMARY->value => [
                'name' => 'primary_balance',
                'balance' => $wallet->primary_balance,
                'type' => $type,
            ],
            WalletType::INVESTMENT->value => [
                'name' => 'investment_balance',
                'balance' => $wallet->investment_balance,
                'type' => $type,
            ],
            WalletType::TRADE->value => [
                'name' => 'trade_balance',
                'balance' => $wallet->trade_balance,
                'type' => $type,
            ],
            WalletType::PRACTICE->value => [
                'name' => 'practice_balance',
                'balance' => $wallet->practice_balance,
                'type' => $type,
            ],
            default => null,
        };
    }


    /**
     * @param int $userId
     * @param int|float|string $amount
     * @param Type $type
     * @param Source $source
     * @param array $account
     * @param string $details
     * @return Transaction
     */
    public function updateTransaction(int $userId, int|float|string $amount, Type $type, Source $source, array $account, string $details): Transaction
    {
        return $this->transactionService->save(
            $this->transactionService->prepParams([
                'user_id' => $userId,
                'amount' => $amount,
                'type' => $type->value,
                'wallet' =>  $account,
                'source' => $source->value,
                'details' => $details,
            ])
        );
    }


    public function executeTransfer(int|float|string $amount, User $user): void
    {
        $setting = SettingService::getSetting();
        $withChargeAmount =  calculateCommissionPlus($amount, getArrayValue($setting->commissions_charge, 'balance_transfer_charge'));

        DB::transaction(function () use ($amount,$withChargeAmount, $user) {
            $wallet = Auth::user()->wallet;
            $wallet->primary_balance -= $withChargeAmount;
            $wallet->save();

            $this->transactionService->save(
                $this->transactionService->prepParams([
                    'user_id' =>  (int)Auth::id(),
                    'amount' => $amount,
                    'type' => Type::MINUS,
                    'wallet' =>  $this->findBalanceByWalletType(WalletType::PRIMARY->value, $wallet),
                    'source' =>Source::ALL,
                    'charge' => $withChargeAmount - $amount,
                    'details' => 'Balance Transferred To '. $user->email,
                ])
            );

            $toWallet = $user->wallet;
            $toWallet->primary_balance += $amount;
            $toWallet->save();

            $this->transactionService->save(
                $this->transactionService->prepParams([
                    'user_id' => $user->id,
                    'amount' => $amount,
                    'type' => Type::PLUS,
                    'wallet' =>  $this->findBalanceByWalletType(WalletType::PRIMARY->value, $toWallet),
                    'source' =>Source::ALL,
                    'details' => 'Balance Transferred From '. $user->email,
                ])
            );

            dispatch(new EmailSmsProcessJob($user, [
                'amount' => $amount,
                'currency' => getCurrencySymbol(),
            ], EmailSmsTemplateName::MATRIX_ENROLLED->value));
        });
    }


    /**
     *
     * @param int|float $amount
     * @param int $walletType
     * @param bool $isAccount
     * @return mixed
     * @throws Exception
     */
    public function checkWalletBalance(int|float $amount, int $walletType, bool $isAccount = false): mixed
    {
        // Refresh the authenticated user's data to ensure the latest information
        $user = Auth::user()->refresh();

        // Fetch the wallet after refreshing the user data
        $wallet = $user->wallet;
        $account = $this->findBalanceByWalletType($walletType, $wallet);

        if (!$account) {
            throw new Exception("Your account was not found.");
        }

        $balance = Arr::get($account, 'balance');

        if ($amount > $balance) {
            throw new Exception("Insufficient funds. Your ". replaceInputTitle(Arr::get($account, 'name')) ." account: " . getCurrencySymbol() . shortAmount($balance));
        }

        if ($isAccount) {
            return [$wallet, $account];
        }

        return $wallet;
    }

}
