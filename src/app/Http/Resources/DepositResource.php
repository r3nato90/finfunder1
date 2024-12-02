<?php

namespace App\Http\Resources;

use App\Enums\Payment\Deposit\Status;
use App\Enums\Transaction\WalletType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepositResource extends JsonResource
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
            'gateway' =>  $this?->gateway?->name ?? 'N/A',
            'amount' => shortAmount($this->amount),
            'charge' => shortAmount($this->charge),
            'final_amount' => shortAmount($this->final_amount),
            'wallet' => WalletType::getWalletName($this->wallet_type),
            'Status' => Status::getName($this->status),
        ];
    }
}
