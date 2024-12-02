<?php

namespace App\Contracts;

use App\Models\Deposit;
use App\Models\PaymentGateway;

interface PaymentGatewayInterface
{
    public function processDeposit(Deposit $deposit, PaymentGateway $paymentGateway);
}
