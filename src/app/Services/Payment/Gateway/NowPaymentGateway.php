<?php

namespace App\Services\Payment\Gateway;

use App\Contracts\PaymentGatewayInterface;
use App\Enums\Payment\Deposit\Status;
use App\Enums\Payment\GatewayCode;
use App\Models\Deposit;
use App\Models\PaymentGateway;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class NowPaymentGateway implements PaymentGatewayInterface
{
    public function processDeposit(Deposit $deposit, PaymentGateway $paymentGateway): ?string
    {
        try {
            $response = Http::withHeaders([
                'x-api-key' => Arr::get($paymentGateway->parameter,'api_key'),
                'Content-Type' => 'application/json',
            ])->post('https://api.nowpayments.io/v1/payment', [
                'price_amount' => $deposit->amount,
                'price_currency' => getCurrencyName(),
                'pay_currency' => getArrayValue($deposit->crypto_meta, 'currency'),
                'ipn_callback_url' =>  route('user.payment.success', ['gateway_code' => GatewayCode::NOW_PAYMENT->value,'trx' => $deposit->trx]),
                'order_id' => getTrx(),
                'order_description' => 'Deposit Amount',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $deposit->crypto_meta = [
                    'currency' => getArrayValue($deposit->crypto_meta, 'currency'),
                    'payment_info' => $data,
                    'image' => cryptoQRCode(getArrayValue($data, 'pay_address')),
                ];
                $deposit->status = Status::PENDING->value;
                $deposit->is_crypto_payment = true;
                $deposit->save();
                return GatewayCode::NOW_PAYMENT->value;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            return null;
        }
    }
}
