<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvestmentPlanResource extends JsonResource
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
            'minimum' => shortAmount($this->minimum),
            'maximum' => shortAmount($this->maximum),
            'amount' => shortAmount($this->amount),
            'interest_rate' => shortAmount($this->interest_rate).\App\Enums\Investment\InterestType::getSymbol($this->interest_type),
            'duration' => $this->duration,
            'is_recommend' => $this->is_recommend,
            'type' => $this->type,
            'terms_policy' => $this->terms_policy,
            'interest_type' => $this->interest_type,
            'time' => $this->timeTable->name,
            'interest_return_type' => $this->interest_return_type,
            'recapture_type' => $this->recapture_type,
            'total_investment_interest' => $this->interest_return_type == \App\Enums\Investment\ReturnType::REPEAT->value ? $this->totalInvestmentInterest() : 'Unlimited',
            'meta' => $this->meta,
        ];
    }


    public  function totalInvestmentInterest(): string
    {
        $interestAmount = 0;
        $capital = '';
        if ($this->recapture_type == \App\Enums\Investment\Recapture::YES->value) {
            $interestAmount = $this->interest_rate * $this->duration;
            $capital = ' + capital';
        } elseif ($this->recapture_type == \App\Enums\Investment\Recapture::NO->value) {
            $interestAmount = $this->interest_rate * $this->duration;
        }elseif ($this->recapture_type == \App\Enums\Investment\Recapture::HOLD->value) {
            $interestAmount = $this->interest_rate * $this->duration;
            $capital = ' + capital';
        }

        return shortAmount($interestAmount) . ($this->interest_type == \App\Enums\Investment\InterestType::PERCENT->value ? '%' : ' ' . getCurrencyName()) . $capital;

    }
}
