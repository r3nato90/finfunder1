<?php

namespace App\Services\Payment\Gateway;

use App\Contracts\PaymentGatewayInterface;
use App\Enums\Payment\GatewayCode;
use App\Models\Deposit;
use App\Models\PaymentGateway;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeGateway implements  PaymentGatewayInterface
{

    public function processDeposit(Deposit $deposit, PaymentGateway $paymentGateway): string
    {
        Stripe::setApiKey(Arr::get($paymentGateway->parameter,'secret_key'));
        $gatewayCode = GatewayCode::STRIPE->value;

        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => getCurrencyName(),
                            'unit_amount' => $deposit->amount * 100,
                            'product_data' => [
                                'name' => 'Deposit Amount',
                                'description' => 'Deposit Amount for wallet',
                            ],
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => route('user.payment.success') . "?payment_intent={CHECKOUT_SESSION_ID}&gateway_code={$gatewayCode}",
                'cancel_url' => route('user.payment.cancel'),
                'metadata' => [
                    'transaction_id' => $deposit->trx,
                ],
            ]);

            return $session->url;

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
