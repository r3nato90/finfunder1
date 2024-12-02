<?php

namespace App\Services\Payment\Gateway;

use App\Contracts\PaymentGatewayInterface;
use App\Enums\Payment\GatewayCode;
use App\Models\Deposit;
use App\Models\PaymentGateway;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalGateway implements PaymentGatewayInterface
{

    public function processDeposit(Deposit $deposit, PaymentGateway $paymentGateway): ?string
    {
        $gatewayCode = GatewayCode::PAYPAL->value;
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            'intent' => 'CAPTURE',
            'application_context' => [
                'return_url' => route('user.payment.success', ['gateway_code' => $gatewayCode,'trx' => $deposit->trx]),
                'cancel_url' => route('user.payment.cancel'),
            ],
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => getCurrencyName(),
                        'value' => $deposit->amount,
                    ],
                ],
            ],
            'items' => [
                [
                    'name' => 'Deposit',
                    'description' => 'Deposit for user',
                    'quantity' => 1,
                    'price' => $deposit->amount,
                    'currency' => getCurrencyName(),
                ],
            ],
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return $links['href'];
                }
            }
        }
        return null;
    }

}
