<?php

namespace App\ModelFilters;

use App\Enums\User\Status;
use Carbon\Carbon;
use EloquentFilter\ModelFilter;
use Illuminate\Support\Facades\DB;

class UserFilter extends ModelFilter
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
     * @return UserFilter
     */
    public function status($status): UserFilter
    {
        $validTypes = [
            Status::ACTIVE->value,
            Status::BANNED->value,
        ];

        $status = match ((int)$status) {
            Status::ACTIVE->value, Status::BANNED->value => [(int)$status],
            default => $validTypes,
        };

        return $this->whereIn('status', $status);
    }

    /**
     * @param $search
     * @return UserFilter
     */
    public function search($search): UserFilter
    {
        return $this->where(function ($q) use ($search) {
            $q->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%$search%")
                ->orWhere('first_name',  'like', "%$search%")
                ->orWhere('last_name',  'like', "%$search%")
                ->orWhere('email',  'like', "%$search%");
        });
    }

    /**
     * @param $value
     * @return UserFilter|$this
     */
    public function date($value): UserFilter
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
