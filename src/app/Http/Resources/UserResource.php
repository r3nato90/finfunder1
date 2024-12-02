<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'referral_id' => $this->uuid,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->fullname,
            'email' => $this->email,
            'phone' => $this->phone,
            'image' => displayImage($this->image),
            'kyc_status' => $this->kyc_status,
            'status' => $this->status,
            'reward_identifier' => $this->reward_identifier,
            'meta' => $this->meta
        ];
    }
}
