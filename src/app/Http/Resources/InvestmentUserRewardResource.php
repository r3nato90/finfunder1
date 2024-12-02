<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvestmentUserRewardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'initiated_at' => showDateTime($this->created_at),
            'id' => $this->id,
            'level' => $this->level,
            'name' => $this->name,
            'reward' => shortAmount($this->reward),
            'invest' => shortAmount($this->invest),
            'team_invest' => shortAmount($this->team_invest),
            'deposit' => shortAmount($this->deposit),
            'minimum_referral' => shortAmount($this->referral_count),
        ];
    }
}
