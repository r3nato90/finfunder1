<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MatrixPlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uid' => $this->uid,
            'name' => $this->name,
            'amount' => shortAmount($this->amount),
            'referral_reward' => shortAmount($this->referral_reward),
            'is_recommend' => $this->is_recommend,
            'status' => $this->status,
            'aggregate_level_commission' =>  \App\Services\Investment\MatrixService::calculateAggregateCommission((int)$this->id),
            'get_back' => shortAmount((\App\Services\Investment\MatrixService::calculateAggregateCommission((int)$this->id) / $this->amount) * 100),
            'level' => MatrixLevelResource::collection($this->matrixLevel)
        ];
    }
}
