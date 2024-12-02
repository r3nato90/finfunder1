<?php

namespace App\Http\Resources;

use App\Enums\Payment\Withdraw\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WithdrawResource extends JsonResource
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
            'gateway' =>  $this?->withdrawMethod?->name ?? 'N/A',
            'amount' => shortAmount($this->amount),
            'charge' => shortAmount($this->charge),
            'final_amount' => shortAmount($this->final_amount),
            'conversion' => getCurrencySymbol() . '1 = ' . shortAmount($this->rate) . ' ' . ($this?->withdrawMethod?->currency_name ?? getCurrencyName()),
            'Status' => Status::getName($this->status),
        ];
    }
}
