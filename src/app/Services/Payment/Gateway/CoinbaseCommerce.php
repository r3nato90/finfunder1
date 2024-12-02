<?php

namespace App\Services\Payment\Gateway;

use App\Contracts\PaymentGatewayInterface;
use App\Enums\Payment\GatewayCode;
use App\Models\Deposit;
use App\Models\PaymentGateway;
use Illuminate\Support\Arr;
use Shakurov\Coinbase\Coinbase;

class CoinbaseCommerce implements PaymentGatewayInterface
{

    public function processDeposit(Deposit $deposit, PaymentGateway $paymentGateway): string
    {
        $gatewayCode = GatewayCode::COINBASE_COMMERCE->value;
        $coinbase = new Coinbase();

        $charge = $coinbase->createCharge([
            'name' => 'Name',
            'description' => 'Description',
            'local_price' => [
                'amount' => $deposit->amount,
                'currency' => getCurrencyName(),
            ],
            'pricing_type' => 'fixed_price',
            'redirect_url' => route('user.payment.success', ['gateway_code' => $gatewayCode,'trx' => $deposit->trx]),
            'cancel_url' => route('user.payment.cancel'),
        ]);

        if (!$charge){
            return redirect()->route('user.payment.index');
        }

        return Arr::get($charge, 'data.hosted_url');
    }


}
