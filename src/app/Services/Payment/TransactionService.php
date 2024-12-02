<?php

namespace App\Services\Payment;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Arr;

class TransactionService
{
    /**
     * @param array $params
     * @return array
     */
    public function prepParams(array $params): array
    {
        return [
            'user_id' => $params['user_id'],
            'amount' => $params['amount'],
            'post_balance' => Arr::get($params['wallet'], 'balance', 0),
            'charge' => $params['charge'] ?? 0,
            'trx' => $params['trx'] ?? getTrx(),
            'type' => $params['type'],
            'wallet_type' => Arr::get($params['wallet'], 'type', 1),
            'source' => $params['source'],
            'details' => $params['details'],
        ];
    }

    /**
     * @param array $transaction
     * @return Transaction
     */
    public function save(array $transaction): Transaction
    {
        return Transaction::create($transaction);
    }


    /**
     * @param array $with
     * @param int|string|null $userId
     * @return AbstractPaginator
     */
    public function getTransactions(array $with = [], int|string $userId = null): AbstractPaginator
    {
        $query = Transaction::query()
            ->filter(request()->all())
            ->when(!is_null($userId), fn ($query) => $query->where('user_id', $userId));

        if (!empty($with)){
            $query->with($with);
        }

        return $query->latest('id')
            ->paginate(getPaginate());
    }


    public function latestTransactions(array $with = [], int $limit = 7, int|string $userId = null): Collection
    {
        $query =  Transaction::query()
            ->filter(request()->all())
            ->when(!is_null($userId), fn ($query) => $query->where('user_id', $userId));

        if (!empty($with)){
            $query->with($with);
        }

        return $query->latest('id')->take($limit)->get();
    }

}
