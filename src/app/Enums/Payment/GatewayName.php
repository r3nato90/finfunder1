<?php

namespace App\Enums\Payment;

enum GatewayName: string
{

    case COINBASE_COMMERCE = 'Coinbase Commerce';
    case STRIPE = 'stripe';
    case PAYPAL = 'paypal';
    case BLOCK_CHAIN = 'Blockchain';
    case COIN_GATE = 'Coingate';
    case PAY_STACK = 'pay-stack';
    case RAZORPAY = 'RazorPay';
    case FLUTTER_WAVE = 'Flutterwave';
    case NOW_PAYMENT = 'NowPayments';
}
