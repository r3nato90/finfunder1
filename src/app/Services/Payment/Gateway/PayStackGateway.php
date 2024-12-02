<?php

namespace App\Services\Payment\Gateway;

use App\Contracts\PaymentGatewayInterface;
use App\Enums\Payment\GatewayCode;
use App\Models\Deposit;
use App\Models\PaymentGateway;
use Illuminate\Support\Facades\Auth;
use Unicodeveloper\Paystack\Facades\Paystack;


class PayStackGateway implements PaymentGatewayInterface
{
    public function processDeposit(Deposit $deposit, PaymentGateway $paymentGateway): ?string
    {
        try {
            return Paystack::getAuthorizationUrl([
                'email' => Auth::user()->email,
                'amount' => $deposit->amount * 100,
                'reference' => $deposit->trx,
                'callback_url' =>  route('user.payment.success', ['gateway_code' => GatewayCode::PAY_STACK->value,'trx' => $deposit->trx]),
                'currency' => strtoupper(getCurrencyName()),
            ])->url;
        } catch (\Exception $e) {
            return null;
        }
    }
}
