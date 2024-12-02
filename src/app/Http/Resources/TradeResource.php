<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TradeResource extends JsonResource
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
            'crypto' => $this->cryptoCurrency->name,
            'price' => shortAmount($this->original_price),
            'amount' =>  shortAmount($this->amount),
            'arrival_time' => showDateTime($this->arrival_time),
            'volume' => \App\Enums\Trade\TradeVolume::getName($this->volume),
            'outcome' => \App\Enums\Trade\TradeOutcome::getName($this->outcome),
            'status' => \App\Enums\Trade\TradeStatus::getName($this->status),
        ];
    }
}
