<?php

namespace App\Services\Payment\Gateway;

use App\Contracts\PaymentGatewayInterface;
use App\Enums\Payment\GatewayCode;
use App\Models\Deposit;
use App\Models\PaymentGateway;
use Illuminate\Support\Facades\Auth;
use KingFlamez\Rave\Facades\Rave as Flutterwave;

class FlutterWaveGateway implements PaymentGatewayInterface
{
    public function processDeposit(Deposit $deposit, PaymentGateway $paymentGateway): ?string
    {
        $gatewayCode = GatewayCode::FLUTTER_WAVE->value;
        $reference = Flutterwave::generateReference();
        $data = [
            'payment_options' => 'card,banktransfer',
            'amount' => $deposit->amount,
            'email' => Auth::user()->email,
            'tx_ref' => $reference,
            'currency' => getCurrencyName(),
            'redirect_url' => route('user.payment.success', ['gateway_code' => $gatewayCode,'trx' => $deposit->trx]),
            'customer' => [
                'email' => Auth::user()->email,
                "phone_number" => Auth::user()->phone ?? '',
                "name" => Auth::user()->name,
            ],

            "customizations" => [
                "title" => 'Deposit payment',
                "description" => "20th October"
            ]
        ];

        $payment = Flutterwave::initializePayment($data);

        if ($payment['status'] !== 'success') {
            return null;
        }

        return $payment['data']['link'];
    }
}
