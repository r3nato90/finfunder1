<?php

namespace App\Services\Payment;

use App\Actions\InvestmentHandler;
use App\Concerns\UploadedFile;
use App\Enums\Payment\Deposit\Status;
use App\Enums\Payment\GatewayType;
use App\Enums\Payment\NotificationType;
use App\Enums\Referral\ReferralCommissionType;
use App\Enums\Transaction\Source;
use App\Enums\Transaction\Type;
use App\Models\PaymentGateway;
use App\Notifications\DepositNotification;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    use UploadedFile;

    public function __construct(
        protected DepositService $depositService,
        protected UserService $userService,
        protected WalletService $walletService,
        protected TransactionService $transactionService,
    ){

    }

    /**
     * @param string $uniqueCode
     * @return PaymentGateway|null
     */
    public function findByCode(string $uniqueCode): ?PaymentGateway
    {
        return PaymentGateway::where('code', $uniqueCode)->first();
    }

    /**
     * @return Collection
     */
    public function fetchActivePaymentGateways(): Collection
    {
        return PaymentGateway::where('status', \App\Enums\Status::ACTIVE->value)->get();
    }

    public function makePayment(PaymentGateway $gateway, Request $request, float|int $amount): mixed
    {
        $deposit = $this->depositService->save(
            $this->depositService->prepParams($gateway,$amount, $request)
        );

        $paymentGateway = PaymentGatewayFactory::create($gateway->code);
        return $paymentGateway->processDeposit($deposit, $gateway);
    }

    /**
     * @param string $trxId
     * @return bool
     */
    public function successPayment(string $trxId): bool
    {
         $deposit = $this->depositService->findByTrxId($trxId);
         $transaction = DB::transaction(function () use ($deposit, $trxId) {
            if (!$deposit) {
                return false;
            }

            if($deposit->gateway->type == GatewayType::MANUAL->value && $deposit->status == Status::INITIATED->value){
                $deposit->status = Status::PENDING->value;
                $deposit->save();
                return true;
            }

            $user = $this->userService->findById((int)$deposit->user_id);
            if (!$user) {
                return false;
            }

            $deposit->status = Status::SUCCESS->value;
            $deposit->save();
            $deposit->refresh();

            $wallet = $user->wallet;
            $walletInfo = $this->walletService->findBalanceByWalletType($deposit->wallet_type, $wallet);
            $name = getArrayValue($walletInfo, 'name', 'primary_balance');

            $wallet->$name += $deposit->final_amount;
            $wallet->save();

             $this->transactionService->save($this->transactionService->prepParams([
                 'user_id' => $user->id,
                 'amount' => $deposit->final_amount,
                 'type' => Type::PLUS,
                 'trx' => $deposit->trx,
                 'charge' => $deposit->charge,
                 'details' => 'Make a Payment with '.$deposit->gateway->name,
                 'wallet' => $this->walletService->findBalanceByWalletType($deposit->wallet_type, $wallet),
                 'source' => Source::ALL->value
             ]));
              return true;
         });

         if ($transaction && $deposit->status == Status::SUCCESS->value) {
             InvestmentHandler::processReferralCommission($deposit->user,$deposit->final_amount,ReferralCommissionType::DEPOSIT,$deposit->trx);
             $deposit->notify(new DepositNotification(NotificationType::APPROVED));
         }

         return $transaction;
    }



    public function parameterStoreData(array $parameters): array
    {
        $value = [];

        if ($parameters) {
            foreach ($parameters as $parameter) {
                $fieldType = Arr::get($parameter, 'field_type', 'text');
                $name = Arr::get($parameter, 'field_name');

                if ($fieldType == "file" && request()->hasFile($name)){
                    Arr::set($value,$name,$this->move(request()->file($name), getFilePath()));
                }else{
                    Arr::set($value, $name, request()->input($name));
                }
            }
        }
        return $value;
    }
}
