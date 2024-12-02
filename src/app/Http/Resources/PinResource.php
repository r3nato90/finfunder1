<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PinResource extends JsonResource
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
            'pin_number' => $this->pin_number,
            'status' => \App\Enums\Matrix\PinStatus::getName((int)$this->status) ,
            'details' => $this->details
        ];
    }
}
