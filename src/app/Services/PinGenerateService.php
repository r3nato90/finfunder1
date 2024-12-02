<?php

namespace App\Services;

use App\Enums\Email\EmailSmsTemplateName;
use App\Enums\Matrix\PinStatus;
use App\Enums\Payment\NotificationType;
use App\Enums\Transaction\Source;
use App\Enums\Transaction\Type;
use App\Enums\Transaction\WalletType;
use App\Jobs\EmailSmsProcessJob;
use App\Models\PinGenerate;
use App\Models\User;
use App\Models\Wallet;
use App\Notifications\DepositNotification;
use App\Notifications\WithdrawNotification;
use App\Services\Payment\DepositService;
use App\Services\Payment\TransactionService;
use App\Services\Payment\WalletService;
use App\Services\Payment\WithdrawService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PinGenerateService
{

    /**
     * @param string $pinNumber
     * @return PinGenerate|null
     */
    public function findByPinNumber(string $pinNumber): ?PinGenerate
    {
        return PinGenerate::where('pin_number', $pinNumber)->first();
    }

    /**
     * @param int|string|null $userId
     * @return AbstractPaginator
     */
    public function getPinsByPaginate(int|string $userId = null): AbstractPaginator
    {
        return PinGenerate::filter(\request()->all())
            ->when(!is_null($userId), fn ($query) => $query->where('set_user_id', $userId))
            ->paginate(getPaginate());
    }


    public function prepParams(int $number, int|float|string $amount, string $details): array
    {
        $pins = [];

        for ($i = 1; $i <=$number ; $i++) {
            $pins[] = [
                'uid' => Str::random(),
                'amount' => $amount,
                'pin_number' => $this->generatePinNumber(),
                'details' => $details,
                'status' => PinStatus::UNUSED->value,
                'created_at' => carbon(),
            ];
        }

        return $pins;
    }


    /**
     * @param array $pins
     * @return void
     */
    public function save(array $pins): void
    {
        try {
            PinGenerate::insert($pins);
        }catch (\Exception $exception){

        }
    }


    /**
     * @return string
     */
    private function generatePinNumber(): string
    {
        return implode('-', [
            rand(10000000, 99999999),
            rand(10000000, 99999999),
            rand(10000000, 99999999),
            rand(10000000, 99999999),
        ]);
    }

    /**
     * @param PinGenerate $pinGenerate
     * @param Authenticatable|User $user
     * @param Wallet $wallet
     * @return void
     */
    public function recharge(PinGenerate $pinGenerate, Authenticatable|User $user, Wallet $wallet): void
    {
        DB::transaction(function () use ($pinGenerate, $wallet, $user) {
            $amount = $pinGenerate->amount;
            $pinGenerate->status = PinStatus::USED->value;
            $pinGenerate->user_id = $user->id;
            $pinGenerate->save();

            $wallet->primary_balance += $amount;
            $wallet->save();

            $transactionService = resolve(TransactionService::class);
            $walletService = resolve(WalletService::class);
            $depositService = resolve(DepositService::class);

            $transactionService->save($transactionService->prepParams([
                'user_id' => Auth::id(),
                'amount' => $amount,
                'type' => Type::PLUS,
                'details' => 'Top up E-Pin with amount ' . getCurrencySymbol() . shortAmount($amount),
                'wallet' => $walletService->findBalanceByWalletType(WalletType::PRIMARY->value, $wallet),
                'source' => Source::ALL->value
            ]));

            dispatch(new EmailSmsProcessJob($user, [
                'amount' => $amount,
                'pin_number' => $pinGenerate->pin_number,
                'currency' => getCurrencySymbol(),
            ], EmailSmsTemplateName::PIN_RECHARGE->value));

            $deposit = $depositService->save($depositService->depositPrepParams($amount));
            $deposit->notify(new DepositNotification(NotificationType::APPROVED));
        });
    }


    /**
     * @param Request $request
     * @param Authenticatable|User $user
     * @param Wallet $wallet
     * @param int|float|string $charge
     * @return void
     */
    public function generate(Request $request, Authenticatable|User $user, Wallet $wallet, int|float|string $charge): void
    {
        $amount = $request->input('amount');
        DB::transaction(function () use ($request, $user, $wallet, $amount, $charge) {
            $params = $this->prepParams(1,$amount - $charge, "Created by a ".$user->fullname);
            foreach ($params as &$param) {
                $param = Arr::add($param, 'set_user_id', $user->id);
            }

            $wallet->primary_balance -= $request->input('amount');
            $wallet->save();

            $transactionService = resolve(TransactionService::class);
            $walletService = resolve(WalletService::class);
            $withdrawService = resolve(WithdrawService::class);

            $this->save($params);
            $transactionService->save($transactionService->prepParams([
                'user_id' => $user->id,
                'amount' => $amount,
                'type' => Type::MINUS,
                'charge' => $charge,
                'details' => 'Generate an E-pin worth '.getCurrencySymbol().shortAmount($amount - $charge),
                'wallet' => $walletService->findBalanceByWalletType(WalletType::PRIMARY->value, $wallet),
                'source' => Source::ALL->value
            ]));

            $withdrawLog = $withdrawService->save($withdrawService->withdrawParams($request->input('amount'), $charge, $user->id));
            $withdrawLog->notify(new WithdrawNotification(NotificationType::APPROVED));
        });
    }

}
