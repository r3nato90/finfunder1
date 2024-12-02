<?php

namespace App\ModelFilters;

use App\Enums\Matrix\PinStatus;
use Carbon\Carbon;
use EloquentFilter\ModelFilter;

class PinGenerateFilter extends ModelFilter
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
     * @return PinGenerateFilter
     */
    public function status($status): PinGenerateFilter
    {
        if(in_array($status, ['all', 'used', 'unused'])){
            $status = match ($status){
                'used' => [PinStatus::USED->value],
                'unused' => [PinStatus::UNUSED->value],
                default => [PinStatus::UNUSED->value,PinStatus::USED->value],
            };

            return $this->whereIn('status', $status);
        }

        if($status == "users"){
            return $this->whereNotNull('set_user_id');
        }

        if($status == "admins"){
            return $this->whereNull('set_user_id');
        }

        return $this;
    }


    /**
     * @param $name
     * @return PinGenerateFilter
     */
    public function search($name): PinGenerateFilter
    {
        return $this->whereHas('setUser', function ($q) use ($name){
            $q->where('email', 'like', "%$name%");
        })->orWhere(function ($q) use ($name) {
            $q->where('pin_number', 'like', "%$name%");
        });
    }

    /**
     * @param $value
     * @return PinGenerateFilter
     */
    public function date($value): PinGenerateFilter
    {
        try {
            $dateRange = explode(' - ', $value);

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
