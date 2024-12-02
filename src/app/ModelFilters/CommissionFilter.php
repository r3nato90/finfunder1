<?php

namespace App\ModelFilters;

use Carbon\Carbon;
use EloquentFilter\ModelFilter;

class CommissionFilter extends ModelFilter
{
    /**
     * @param $name
     * @return CommissionFilter
     */
    public function search($name): CommissionFilter
    {
        return $this->where(function ($q) use ($name) {
            $q->where('trx', 'like', "%$name%")
                ->orWhereHas('user', function ($query) use ($name){
                    $query->where('email',  'like', "%$name%");
                });
        });
    }

    public function date($value): CommissionFilter
    {
        try {
            $dateRange = explode('-', $value);

            $firstDate = isset($dateRange[0]) ? Carbon::createFromFormat('m/d/Y', trim($dateRange[0]))->startOfDay() : null;
            $lastDate = isset($dateRange[1]) ? Carbon::createFromFormat('m/d/Y', trim($dateRange[1]))->endOfDay() : null;

            if ($firstDate !== null && $lastDate !== null) {
                return $this->whereDate('created_at', '>=', $firstDate)->whereDate('created_at', '<=', $lastDate);
            }

            if ($firstDate !== null) {
                return $this->whereDate('created_at', '>=', $firstDate);
            }

            return $this;

        }catch (\Exception $exception){
            return $this;
        }
    }

}
