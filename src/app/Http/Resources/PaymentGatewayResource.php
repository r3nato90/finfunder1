<?php

namespace App\Http\Resources;

use App\Enums\Payment\GatewayType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentGatewayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $parameter = $this->type == GatewayType::MANUAL->value ? $this->parameter : null;

        return [
            'name' => $this->name,
            'type' => $this->type,
            'minimum' => shortAmount($this->minimum),
            'maximum' => shortAmount($this->maximum),
            'details' => $this->details,
            'file' => displayImage($this->file),
            'code' => $this->code,
            'parameters' => $parameter,
        ];
    }
}
