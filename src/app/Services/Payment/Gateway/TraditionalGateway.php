<?php

namespace App\Services\Payment\Gateway;

use App\Contracts\PaymentGatewayInterface;
use App\Models\Deposit;
use App\Models\PaymentGateway;

class TraditionalGateway implements PaymentGatewayInterface
{
    public function processDeposit(Deposit $deposit, PaymentGateway $paymentGateway): string
    {
        return route('user.payment.preview') . "?payment_intent={$deposit->trx}&gateway_code={$paymentGateway->code}";
    }
}
