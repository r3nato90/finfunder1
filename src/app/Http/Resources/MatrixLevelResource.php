<?php

namespace App\Http\Resources;

use App\Services\Investment\MatrixService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MatrixLevelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $matrix = pow(MatrixService::getMatrixWidth(), $this->level);

        return [
            'level' => 'Level-'.$this->level,
            'amount' => $this->amount,
            'matrix' => shortAmount($matrix),
            'total' => shortAmount($this->amount * $matrix),
        ];
    }
}
