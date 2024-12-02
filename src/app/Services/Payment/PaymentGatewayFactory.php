<?php

namespace App\Services\Payment;

use App\Contracts\PaymentGatewayInterface;
use App\Enums\Payment\GatewayCode;
use App\Services\Payment\Gateway\BlockChainGateway;
use App\Services\Payment\Gateway\CoinbaseCommerce;
use App\Services\Payment\Gateway\CoinGateGateway;
use App\Services\Payment\Gateway\FlutterWaveGateway;
use App\Services\Payment\Gateway\NowPaymentGateway;
use App\Services\Payment\Gateway\PaypalGateway;
use App\Services\Payment\Gateway\PayStackGateway;
use App\Services\Payment\Gateway\StripeGateway;
use App\Services\Payment\Gateway\TraditionalGateway;

class PaymentGatewayFactory
{
    public static function create(string $gatewayName): PaymentGatewayInterface {
        return match ($gatewayName) {
            GatewayCode::STRIPE->value => new StripeGateway(),
            GatewayCode::PAYPAL->value => new PaypalGateway(),
            GatewayCode::COINBASE_COMMERCE->value => new CoinbaseCommerce(),
            GatewayCode::BLOCK_CHAIN->value => new BlockChainGateway(),
            GatewayCode::COIN_GATE->value => new CoinGateGateway(),
            GatewayCode::FLUTTER_WAVE->value => new FlutterWaveGateway(),
            GatewayCode::PAY_STACK->value => new PayStackGateway(),
            GatewayCode::NOW_PAYMENT->value => new NowPaymentGateway(),
            default => new TraditionalGateway(),
        };
    }

}
