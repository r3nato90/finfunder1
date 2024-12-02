<?php

namespace App\ModelFilters;

use App\Enums\Trade\TradeOutcome;
use App\Enums\Trade\TradeStatus;
use App\Enums\Trade\TradeVolume;
use App\Enums\User\Status;
use Carbon\Carbon;
use EloquentFilter\ModelFilter;

class TradeLogFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function status($status): TradeLogFilter
    {
        $validTypes = [
            TradeStatus::RUNNING->value,
            TradeStatus::COMPLETE->value,
        ];

        $status = match ((int)$status) {
            TradeStatus::RUNNING->value, TradeStatus::COMPLETE->value => [(int)$status],
            default => $validTypes,
        };

        return $this->whereIn('status', $status);
    }

    /**
     * @param $status
     * @return TradeLogFilter
     */
    public function outcome($status): TradeLogFilter
    {
        $validTypes = [
            TradeOutcome::INITIATED->value,
            TradeOutcome::WIN->value,
            TradeOutcome::LOSE->value,
            TradeOutcome::DRAW->value,
        ];

        $status = match ((int)$status) {
            TradeOutcome::INITIATED->value, TradeOutcome::WIN->value, TradeOutcome::LOSE->value, TradeOutcome::DRAW->value  => [(int)$status],
            default => $validTypes,
        };

        return $this->whereIn('outcome', $status);
    }

    public function volume($status): TradeLogFilter
    {
        $validTypes = [
            TradeVolume::HIGH->value,
            TradeVolume::LOW->value,
        ];

        $status = match ((int)$status) {
            TradeVolume::HIGH->value, TradeVolume::LOW->value => [(int)$status],
            default => $validTypes,
        };

        return $this->whereIn('volume', $status);
    }

    /**
     * @param $name
     * @return TradeLogFilter
     */
    public function search($name): TradeLogFilter
    {
        return $this->where(function ($q) use ($name) {
            $q->whereHas('user', function ($query) use ($name){
                $query->where('email',  'like', "%$name%");
            })->orWhereHas('cryptoCurrency', function ($query) use ($name){
                $query->where('name',  'like', "%$name%");
            });
        });
    }

    /**
     * @param $value
     * @return TradeLogFilter
     */
    public function date($value): TradeLogFilter
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
