<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StakingPlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'minimum_amount' => shortAmount($this->minimum_amount),
            'maximum_amount' => shortAmount($this->maximum_amount),
            'interest_rate' => shortAmount($this->interest_rate),
            'duration' => $this->duration,
        ];
    }
}
