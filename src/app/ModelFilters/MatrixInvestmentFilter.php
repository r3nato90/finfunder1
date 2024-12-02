<?php

namespace App\ModelFilters;

use App\Enums\Matrix\InvestmentStatus;
use Carbon\Carbon;
use EloquentFilter\ModelFilter;

class MatrixInvestmentFilter extends ModelFilter
{

    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    /**
     * @param $status
     * @return MatrixInvestmentFilter
     */
    public function status($status): MatrixInvestmentFilter
    {
        $validTypes = [
            InvestmentStatus::RUNNING->value,
            InvestmentStatus::CLOSED->value,
        ];

        $status = match ((int)$status) {
            InvestmentStatus::RUNNING->value, InvestmentStatus::CLOSED->value => [(int)$status],
            default => $validTypes,
        };

        return $this->whereIn('status', $status);
    }


    /**
     * @param $name
     * @return MatrixInvestmentFilter
     */
    public function search($name): MatrixInvestmentFilter
    {
        return $this->where(function ($q) use ($name) {
            $q->where('trx', 'like', "%$name%")
                ->orWhereHas('user', function ($query) use ($name){
                    $query->where('email',  'like', "%$name%");
                });
        });
    }

    public function date($value): MatrixInvestmentFilter
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
