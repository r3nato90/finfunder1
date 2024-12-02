<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CryptoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'file' => $this->file,
            'pair' => $this->pair,
            'price' => shortAmount($this->original_price),
            'market_cap' => getArrayValue($this->meta, 'market_cap'),
            'daily_high' =>  getArrayValue($this->meta, 'high_24h'),
            'daily_low' => getArrayValue($this->meta, 'low_24h'),
        ];
    }
}
