<?php

namespace App\Http\Controllers\Payment;

use App\Enums\Payment\Deposit\Status;
use App\Http\Controllers\Controller;
use App\Services\Payment\DepositService;
use App\Services\Payment\Gateway\BlockChainGateway;
use App\Services\Payment\PaymentService;
use Illuminate\Http\Request;

class IpnController extends Controller
{

    public function __construct(
        protected DepositService $depositService,
        protected PaymentService $paymentService,
    )
    {

    }
    public function blockchain(Request $request): void
    {
        $valueInBtc = $request->input('value') / 100000000;
        $deposit = $this->depositService->findByTrxId($request->input('invoice_id'));
        if(!$deposit){
            abort(404);
        }

        if ($deposit->btc_amount == $valueInBtc && $request->input('address') == $deposit->btc_wallet && $request->input('secret') == BlockChainGateway::SECRET && $request->confirmations > 2 && $deposit->status == Status::INITIATED->value) {
            $this->paymentService->successPayment($deposit->trx);
        }
    }
}
