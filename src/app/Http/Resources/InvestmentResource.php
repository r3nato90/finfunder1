<?php

namespace App\Http\Resources;

use App\Enums\Investment\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvestmentResource extends JsonResource
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
            'uid' => $this->uid,
            'trx' => $this->trx,
            'plan' => $this->plan_name,
            'plan_uid' => $this->plan->uid,
            'amount' => shortAmount($this->amount),
            'profit' => shortAmount($this->profit),
            'interest_rate' => shortAmount($this->interest_rate),
            'expiration_date' => showDateTime($this->expiration_date),
            'interest_type' => $this->interest_type,
            'should_pay' => $this->should_pay != -1 ? getCurrencySymbol(). shortAmount($this->should_pay) : '****',
            'status' => $this->status,
        ];
    }
}
