<?php

namespace App\ModelFilters;

use Carbon\Carbon;
use EloquentFilter\ModelFilter;

class StakingInvestmentFilter extends ModelFilter
{
    /**
     * @param $name
     * @return StakingInvestmentFilter
     */
    public function search($name): StakingInvestmentFilter
    {
        return $this->where(function ($q) use ($name) {
            $q->whereHas('user', function ($query) use ($name){
                $query->where('email',  'like', "%$name%");
            });
        });
    }

    /**
     * @param $value
     * @return StakingInvestmentFilter
     */
    public function date($value): StakingInvestmentFilter
    {
        try {
            $dateRange = explode(' - ', $value);

            $firstDate = isset($dateRange[0]) ? Carbon::createFromFormat('m/d/Y', trim($dateRange[0]))->startOfDay() : null;
            $lastDate = isset($dateRange[1]) ? Carbon::createFromFormat('m/d/Y', trim($dateRange[1]))->endOfDay() : null;

            if ($firstDate !== null && $lastDate !== null) {
                return $this->whereDate('expiration_date', '>=', $firstDate)->whereDate('expiration_date', '<=', $lastDate);
            }

            if ($firstDate !== null) {
                return $this->whereDate('expiration_date', '>=', $firstDate);
            }

            return $this;

        }catch (\Exception $exception){
            return $this;
        }
    }
}
