<?php

namespace Database\Seeders;

use App\Enums\Payment\GatewayCode;
use App\Enums\Payment\GatewayName;
use App\Enums\Payment\GatewayStatus;
use App\Enums\Payment\GatewayType;
use App\Models\PaymentGateway;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gateways = [
            [
                "currency" => getCurrencyName(),
                "percent_charge" => "0.00000000",
                "rate" => "1.00000000",
                "name" => replaceInputTitle(GatewayName::STRIPE->value),
                "code" => GatewayCode::STRIPE->value,
                "minimum" => "100",
                "maximum" => "100000",
                "file" => "stripe.png",
                "parameter" => [
                    "secret_key" => "##################",
                    "publishable_key" => "#####################",
                ],
                "status" => GatewayStatus::ACTIVE->value,
                "type" => GatewayType::AUTOMATIC->value,
            ],
            [
                "currency" => getCurrencyName(),
                "percent_charge" => "1.00000000",
                "rate" => "1.00000000",
                "name" => replaceInputTitle(GatewayName::PAYPAL->value),
                "code" => GatewayCode::PAYPAL->value,
                "minimum" => "100",
                "maximum" => "100000",
                "file" => "paypal.png",
                "parameter" => [
                    "environment" => "sandbox",
                    "client_id" => "############",
                    "secret" => "##############",
                    "app_id" => "#################",
                ],
                "status" => GatewayStatus::ACTIVE->value,
                "type" => GatewayType::AUTOMATIC->value,
            ],
            [
                "currency" => getCurrencyName(),
                "percent_charge" => "1.00000000",
                "rate" => "10.00000000",
                "name" => replaceInputTitle(GatewayName::FLUTTER_WAVE->value),
                "code" => GatewayCode::FLUTTER_WAVE->value,
                "minimum" => "100",
                "maximum" => "100000",
                "file" => "flutter-wave.png",
                "parameter" => [
                    "public_key" => "############",
                    "secret_key" => "############",
                    "secret_hash" => "############",
                ],
                "status" => GatewayStatus::ACTIVE->value,
                "type" => GatewayType::AUTOMATIC->value,
            ],
            [
                "currency" => getCurrencyName(),
                "percent_charge" => "1.00000000",
                "rate" => "10.00000000",
                "name" => replaceInputTitle(GatewayName::PAY_STACK->value),
                "code" => GatewayCode::PAY_STACK->value,
                "minimum" => "100",
                "maximum" => "100000",
                "file" => "pay-stack.png",
                "parameter" => [
                    "public_key" => "############",
                    "secret_key" => "############",
                    "payment_url" => "https://api.paystack.co",
                    "merchant_email" => "#######@gmail.com",
                ],
                "status" => GatewayStatus::ACTIVE->value,
                "type" => GatewayType::AUTOMATIC->value,
            ],
            [
                "currency" => getCurrencyName(),
                "percent_charge" => "1.00000000",
                "rate" => "10.00000000",
                "name" => replaceInputTitle(GatewayName::BLOCK_CHAIN->value),
                "code" => GatewayCode::BLOCK_CHAIN->value,
                "minimum" => "100",
                "maximum" => "100000",
                "file" => "block-chain.png",
                "parameter" => [
                    "key" => "####################",
                    "xpub_code" => "#########################",
                ],
                "status" => GatewayStatus::ACTIVE->value,
                "type" => GatewayType::AUTOMATIC->value,
            ],
            [
                "currency" => getCurrencyName(),
                "percent_charge" => "1.00000000",
                "rate" => "10.00000000",
                "name" => replaceInputTitle(GatewayName::COIN_GATE->value),
                "code" => GatewayCode::COIN_GATE->value,
                "minimum" => "100",
                "maximum" => "100000",
                "file" => "coin-gate.png",
                "parameter" => [
                    "api_key" => "####################",
                ],
                "status" => GatewayStatus::ACTIVE->value,
                "type" => GatewayType::AUTOMATIC->value,
            ],
            [
                "currency" => getCurrencyName(),
                "percent_charge" => "1.00000000",
                "rate" => "1.00000000",
                "name" => replaceInputTitle(GatewayName::COINBASE_COMMERCE->value),
                "code" => GatewayCode::COINBASE_COMMERCE->value,
                "minimum" => "100",
                "maximum" => "100000",
                "file" => "coinbase-commerce.png",
                "parameter" => [
                    "api_key" => "###########",
                ],
                "status" => GatewayStatus::ACTIVE->value,
                "type" => GatewayType::AUTOMATIC->value,
            ],
            [
                "currency" => getCurrencyName(),
                "percent_charge" => "0.00000000",
                "rate" => "1.00000000",
                "name" => replaceInputTitle(GatewayName::NOW_PAYMENT->value),
                "code" => GatewayCode::NOW_PAYMENT->value,
                "minimum" => "100",
                "maximum" => "100000",
                "file" => "now-payment-gateway.png",
                "parameter" => [
                    "api_key" => "##################",
                ],
                "status" => GatewayStatus::ACTIVE->value,
                "type" => GatewayType::AUTOMATIC->value,
            ],
            [
                "currency" => getCurrencyName(),
                "percent_charge" => "3.00000000",
                "rate" => "1.00000000",
                "name" => "Payment Solutions",
                "code" => Str::random(5),
                "minimum" => "100",
                "maximum" => "100000",
                "file" => "atm-card.png",
                "parameter" => [
                    "trx" => [
                        "field_label" => "Trx",
                        "field_name" => "trx",
                        "field_type" => "text"
                    ],
                ],
                "status" => GatewayStatus::ACTIVE->value,
                "type" => GatewayType::MANUAL->value,
                "details" => "In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual",
            ],
            [
                "currency" => getCurrencyName(),
                "percent_charge" => "3.00000000",
                "rate" => "1.00000000",
                "name" => "Bank Solutions",
                "code" => Str::random(5),
                "minimum" => "100",
                "maximum" => "100000",
                "file" => "online-payment.png",
                "parameter" => [
                    "trx" => [
                        "field_label" => "Trx",
                        "field_name" => "trx",
                        "field_type" => "text"
                    ],
                ],
                "status" => GatewayStatus::ACTIVE->value,
                "type" => GatewayType::MANUAL->value,
                "details" => "In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual",
            ],
        ];

        PaymentGateway::truncate();
        collect($gateways)->each(fn($gateway) => PaymentGateway::create($gateway));
    }
}
