<?php

namespace App\Services;

use App\Enums\Email\EmailSmsTemplateName;
use App\Enums\Payment\NotificationType;
use App\Enums\Transaction\Source;
use App\Enums\Transaction\Type;
use App\Enums\Transaction\WalletType;
use App\Enums\User\Status;
use App\Jobs\EmailSmsProcessJob;
use App\Models\User;
use App\Models\Wallet;
use App\Notifications\DepositNotification;
use App\Notifications\WithdrawNotification;
use App\Services\Payment\DepositService;
use App\Services\Payment\TransactionService;
use App\Services\Payment\WalletService;
use App\Services\Payment\WithdrawService;
use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Arr;

class UserService
{
    public function __construct(
        protected TransactionService $transactionService,
        protected WalletService $walletService,
        protected DepositService $depositService,
        protected WithdrawService $withdrawService,
    ){

    }


    /**
     * @param array $with
     * @return AbstractPaginator
     */
    public function getUsersByPaginate(array $with = []): AbstractPaginator
    {
        $query = User::query();

        if(!empty($with)){
            $query->with($with);
        }

        return $query->filter(\request()->all())
            ->paginate(getPaginate());
    }


    /**
     * @param array $with
     * @return AbstractPaginator
     */
    public function getUsersIdentityByPaginate(array $with = []): AbstractPaginator
    {
        $query = User::query();

        if(!empty($with)){
            $query->with($with);
        }

        return $query->orderBy('kyc_status', 'DESC')->paginate(getPaginate());
    }


    /**
     * @param int|string $id
     * @return User|null
     */
    public function findById(int|string $id): ?User
    {
        return User::find($id);
    }

    /**
     * @param string $uuid
     * @return User|null
     */
    public function findByUuid(string $uuid): ?User
    {
        return User::where('uuid', $uuid)->first();
    }

    public function getReferral(): ?User
    {
        $referral = null;

        if (session()->get('reference_uuid')) {
            $referral = $this->findByUuid(session()->get('reference_uuid'));
        }

        return $referral;
    }

    /**
     * @param Request $request
     * @return string
     */
    public function addSubtractBalance(Request $request): string
    {
        $user = $this->findById($request->integer('id'));
        $amount = $request->input('amount');
        $wallet = $user?->wallet;
        $walletName = WalletType::getColumn($request->integer('wallet_type'));

        if ($request->integer('type') == Type::PLUS->value) {
            $wallet->$walletName +=  $amount;
            $wallet->save();

            $this->transactionProcess($user,Type::PLUS, $request, $wallet);
            return getCurrencySymbol().$amount.' has been added to ' . $user->fullname . 'wallet '.  WalletType::getName($request->integer('wallet_type'));
        }

        $wallet->$walletName -=  $amount;
        $wallet->save();

        $this->transactionProcess($user,Type::MINUS, $request, $wallet);
        return getCurrencySymbol().$amount.' has been subtracted from ' . $user->fullname . 'wallet '.  WalletType::getName($request->integer('wallet_type'));
    }


    /**
     * @param User $user
     * @param Type $type
     * @param Request $request
     * @param Wallet $wallet
     * @return void
     */
    protected function transactionProcess(User $user, Type $type, Request $request, Wallet $wallet): void
    {
        $amount = $request->input('amount');
        $details = $type->value == Type::PLUS->value ? 'Added Balance Via Admin' : 'Subtract Balance Via Admin';
        $account = $this->walletService->findBalanceByWalletType($request->integer('wallet_type'), $wallet);
        $this->walletService->updateTransaction($user->id, $amount, $type, Source::ALL, $account, $details);

        $emailSmsTemplateName = $type->value == Type::PLUS->value ? EmailSmsTemplateName::BALANCE_ADD->value : EmailSmsTemplateName::BALANCE_SUBTRACT->value;
        if ($type->value == Type::PLUS->value){
            $deposit = $this->depositService->save($this->depositService->depositPrepParams($amount, userId: $user->id));
            $deposit->notify(new DepositNotification(NotificationType::APPROVED));
        }else{
            $withdrawLog = $this->withdrawService->save($this->withdrawService->withdrawParams($amount, userId: $user->id));
            $withdrawLog->notify(new WithdrawNotification(NotificationType::APPROVED));
        }

        dispatch(new EmailSmsProcessJob($user, [
            'wallet_name' => WalletType::getWalletName($request->integer('wallet_type')),
            'amount' => shortAmount($request->input('amount')),
            'currency' => getCurrencySymbol(),
            'post_balance' => shortAmount(Arr::get($account, 'balance', 0.00)),
        ], $emailSmsTemplateName));
    }


    public function getUserByColumn(array $column)
    {
        return User::where('status', Status::ACTIVE->value)->select($column)->get();
    }


}
