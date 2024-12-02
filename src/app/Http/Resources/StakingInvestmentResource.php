<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StakingInvestmentResource extends JsonResource
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
             'amount' => shortAmount($this->amount),
             'interest' => shortAmount($this->interest),
             'total_return' => shortAmount($this->amount + $this->interest),
             'expiration_date' => showDateTime($this->expiration_date),
             'status' => \App\Enums\Investment\Staking\Status::getName((int)$this->status)
        ];
    }
}
