<?php

namespace App\ModelFilters;

use App\Enums\Status;
use EloquentFilter\ModelFilter;

class CryptoCurrencyFilter extends ModelFilter
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
     * @return CryptoCurrencyFilter
     */
    public function status($status): CryptoCurrencyFilter
    {
        $validTypes = [
            Status::ACTIVE->value,
            Status::INACTIVE->value,
        ];

        $status = match ((int)$status) {
            Status::ACTIVE->value, Status::INACTIVE->value => [(int)$status],
            default => $validTypes,
        };

        return $this->whereIn('status', $status);
    }


    /**
     * @param $name
     * @return CryptoCurrencyFilter
     */
    public function search($name): CryptoCurrencyFilter
    {
        return $this->where(function ($q) use ($name) {
            $q->where('name', 'like', "%$name%")
                ->orWhere('pair', 'like', "%$name%")
                ->orWhere('symbol', 'like', "%$name%");
        });
    }
}
