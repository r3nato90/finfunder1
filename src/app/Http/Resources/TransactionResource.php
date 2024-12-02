<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'initiated_at' => showDateTime($this->created_at),
            'trx' => $this->trx,
            'amount' => shortAmount($this->amount),
            'type' => $this->type,
            'post_balance' => \App\Enums\Transaction\WalletType::getName((int)$this->wallet_type) .' : '. getCurrencySymbol().shortAmount($this->post_balance),
            'Charge' => shortAmount($this->charge),
            'source' => \App\Enums\Transaction\Source::getName((int)$this->source),
            'wallet' => \App\Enums\Transaction\WalletType::getWalletName((int)$this->wallet_type),
            'details' => $this->details,
        ];
    }
}
