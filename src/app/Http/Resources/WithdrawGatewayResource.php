<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WithdrawGatewayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'id' => $this->id,
            'name' => $this->name,
            'min_limit' => shortAmount($this->min_limit),
            'max_limit' => shortAmount($this->max_limit),
            'parameters' => $this->parameter,
        ];
    }
}
