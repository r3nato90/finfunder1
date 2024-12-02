<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'primary_balance' => shortAmount($this->primary_balance),
            'investment_balance' => shortAmount($this->investment_balance),
            'trade_balance' => shortAmount($this->trade_balance),
            'practice_balance' => shortAmount($this->practice_balance),
        ];
    }
}
