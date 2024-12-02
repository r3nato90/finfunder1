<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommissionResource extends JsonResource
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
            'from_user' => $this->fromUser->email ?? null,
            'details' => $this->details
        ];
    }
}
