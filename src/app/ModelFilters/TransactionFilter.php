<?php

namespace App\ModelFilters;

use App\Enums\Transaction\Source;
use App\Enums\Transaction\Type;
use App\Enums\Transaction\WalletType;
use Carbon\Carbon;
use EloquentFilter\ModelFilter;

class TransactionFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    /**
     * @param $trx
     * @return TransactionFilter
     */
    public function search($trx): TransactionFilter
    {
        return $this->where(function ($q) use ($trx) {
            $q->where('trx', 'like', "%$trx%");
        });
    }


    public function walletType($type): TransactionFilter
    {
        $validTypes = [
            WalletType::PRIMARY->value,
            WalletType::INVESTMENT->value,
            WalletType::TRADE->value
        ];

        $status = match ((int)$type) {
            WalletType::PRIMARY->value, WalletType::INVESTMENT->value, WalletType::TRADE->value, WalletType::PRACTICE->value => [(int)$type],
            default => $validTypes,
        };

        return $this->whereIn('wallet_type', $status);
    }

    /**
     * @param $type
     * @return TransactionFilter
     */
    public function type($type): TransactionFilter
    {
        $validTypes = [
            Type::PLUS->value,
            Type::MINUS->value,
        ];

        $status = match ((int)$type) {
            Type::PLUS->value, Type::MINUS->value => [(int)$type],
            default => $validTypes,
        };

        return $this->whereIn('type', $status);
    }

    /**
     * @param $name
     * @return TransactionFilter
     */
    public function source($name): TransactionFilter
    {
        $validTypes = [
            Source::ALL->value,
            Source::MATRIX->value,
            Source::INVESTMENT->value,
            Source::TRADE->value,
        ];

        $status = match ((int)$name) {
            Source::ALL->value, Source::MATRIX->value, Source::INVESTMENT->value, Source::TRADE->value => [(int)$name],
            default => $validTypes,
        };

        return $this->whereIn('source', $status);
    }



    /**
     * @param $value
     * @return TransactionFilter
     */
    public function date($value): TransactionFilter
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
