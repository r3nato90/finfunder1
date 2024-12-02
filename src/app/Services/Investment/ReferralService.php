<?php

namespace App\Services\Investment;

use App\Models\Referral;
use Illuminate\Http\Request;

class ReferralService
{
    public function get()
    {
        return Referral::get();
    }

    public function prepParams(Request $request): array
    {
        $levels = [];

        for ($i = 0; $i < count($request->input('percent')) ; $i++) {
            $levels[] = [
                'level' => $i + 1,
                'percent' => $request->input('percent')[$i],
                'commission_type' => $request->input('commission_type'),
            ];
        }

        return $levels;
    }


    public function save(array $params): void
    {
        Referral::insert($params);
    }


    public function deleteByCommissionType(string|int $type): void
    {
        Referral::where('commission_type', $type)->delete();
    }


}
