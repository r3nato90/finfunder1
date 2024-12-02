<?php
namespace App\Services\Payment\Gateway;

use App\Contracts\PaymentGatewayInterface;
use App\Models\Deposit;
use App\Models\PaymentGateway;
use Illuminate\Support\Facades\Http;

class BlockChainGateway implements PaymentGatewayInterface
{
    private const BLOCKCHAIN_TICKER_URL = "https://blockchain.info/ticker";
    private const BLOCKCHAIN_RECEIVE_ROOT = "https://api.blockchain.info/";
    public const SECRET = "block-innovation-secret";

    public function processDeposit(Deposit $deposit, PaymentGateway $paymentGateway): ?string
    {
        $blockchainAcc = $paymentGateway->parameter;
        $btcRate = $this->getBtcRate();
        $btcAmount =  round($deposit->final_amount / $btcRate, 8);

        if ($this->isNewBtcAddressRequired($deposit)) {
            $btcWallet = $this->generateBtcAddress($blockchainAcc, $deposit);
            if ($btcWallet == null) {
                return null;
            }
            $deposit->update([
                'btc_wallet' => $btcWallet,
                'btc_amount' => $btcAmount,
            ]);
        }

        return route('user.payment.preview') . "?payment_intent={$deposit->trx}&gateway_code={$paymentGateway->code}";
    }

    private function getBtcRate(): float|int
    {
        $response = Http::get(self::BLOCKCHAIN_TICKER_URL);
        if ($response->failed()) {
            return 0;
        }

        return $response->json('USD.last', 0);
    }


    private function isNewBtcAddressRequired(Deposit $deposit): bool
    {
        return $deposit->btc_amount == 0 || $deposit->btc_wallet == "";
    }

    private function generateBtcAddress($blockchainAcc, Deposit $deposit): ?string
    {
        try {
            $callbackUrl = route('ipn.blockchain', [
                'invoice_id' => $deposit->trx,
                'secret' => self::SECRET
            ]);

            $url = self::BLOCKCHAIN_RECEIVE_ROOT . "v2/receive?" . http_build_query([
                    'key' => $blockchainAcc['key'] ?? '',
                    'callback' => urlencode($callbackUrl),
                    'xpub' => $blockchainAcc['xpub_code'] ?? ''
                ]);

            $response = Http::get($url)->json();
            return $response['address'] ?? null;
        }catch (\Exception $exception){

        }
    }
}
