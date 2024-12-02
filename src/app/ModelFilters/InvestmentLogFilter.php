<?php

namespace App\ModelFilters;

use App\Enums\Investment\Status;
use Carbon\Carbon;
use EloquentFilter\ModelFilter;

class InvestmentLogFilter extends ModelFilter
{
    /**
     * @param $status
     * @return InvestmentLogFilter
     */
    public function status($status): InvestmentLogFilter
    {
        $validTypes = [
            Status::INITIATED->value,
            Status::PROFIT_COMPLETED->value,
            Status::COMPLETED->value,
            Status::CANCELLED->value,
        ];

        $status = match ((int)$status) {
            Status::INITIATED->value,Status::PROFIT_COMPLETED->value,Status::COMPLETED->value,Status::CANCELLED->value => [(int)$status],
            default => $validTypes,
        };

        return $this->whereIn('status', $status);
    }

    /**
     * @param $name
     * @return InvestmentLogFilter
     */
    public function search($name): InvestmentLogFilter
    {
        return $this->where(function ($q) use ($name) {
            $q->where('trx', 'like', "%$name%")
                ->orWhere('plan_name', 'like', "%$name%")
                ->orWhereHas('user', function ($query) use ($name){
                    $query->where('email',  'like', "%$name%");
                });
        });
    }

    /**
     * @param $value
     * @return InvestmentLogFilter
     */
    public function date($value): InvestmentLogFilter
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
