<?php
namespace App\ModelFilters;

use App\Enums\Payment\Deposit\Status;
use App\Enums\Payment\GatewayType;
use Carbon\Carbon;
use EloquentFilter\ModelFilter;

class DepositFilter extends ModelFilter
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
     * @return DepositFilter
     */
    public function status($status): DepositFilter
    {
        $validTypes = [
            Status::INITIATED->value,
            Status::PENDING->value,
            Status::SUCCESS->value,
            Status::CANCEL->value,
        ];

        $status = match ((int)$status) {
            Status::INITIATED->value,Status::PENDING->value,Status::SUCCESS->value,Status::CANCEL->value  => [(int)$status],
            default => $validTypes,
        };

        return $this->whereIn('status', $status);
    }

    /**
     * @param $status
     * @return DepositFilter
     */
    public function paymentProcessor($status): DepositFilter
    {
        $value = GatewayType::getValue($status);

        return $this->where(function ($q) use ($value) {
            $q->whereHas('gateway', function ($query) use ($value){
                $query->where('type', $value);
            });
        });
    }


    /**
     * @param $name
     * @return DepositFilter
     */
    public function search($name): DepositFilter
    {
        return $this->where(function ($q) use ($name) {
            $q->where('trx', 'like', "%$name%")
                ->orWhereHas('user', function ($query) use ($name){
                    $query->where('email',  'like', "%$name%");
                });
        });
    }

    /**
     * @param $value
     * @return DepositFilter
     */
    public function date($value): DepositFilter
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

