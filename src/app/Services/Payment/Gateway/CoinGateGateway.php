<?php

namespace App\Services\Payment\Gateway;

use App\Contracts\PaymentGatewayInterface;
use App\Enums\Payment\GatewayCode;
use App\Models\Deposit;
use App\Models\PaymentGateway;


class CoinGateGateway implements PaymentGatewayInterface
{
    public function processDeposit(Deposit $deposit, PaymentGateway $paymentGateway): ?string
    {
        try {
            $gatewayCode = GatewayCode::COIN_GATE->value;
            $coinGateAcc = $paymentGateway->parameter;

            $client = new \CoinGate\Client($coinGateAcc['api_key'] ?? '');
            $params = [
                'order_id'          => $deposit->trx,
                'price_amount'      => round($deposit->final_amount,2),
                'price_currency'    => getCurrencyName(),
                'receive_currency'  => getCurrencyName(),
                'callback_url'      => route('user.payment.success') . "?payment_intent={$deposit->trx}&gateway_code={$gatewayCode}",
                'cancel_url'        => route('user.payment.cancel'),
                'success_url'       => route('user.payment.success') . "?payment_intent={$deposit->trx}&gateway_code={$gatewayCode}",
                'title'             => 'Payment to ' . getSiteTitle(),
                'description'       => 'Deposit payment to ' . getSiteTitle(),
            ];
            $data = $client->order->create($params);

        } catch (\CoinGate\Exception\ApiErrorException $e) {
            dd(json_encode($e->getErrorDetails()));
            return null;
        }
    }
}
