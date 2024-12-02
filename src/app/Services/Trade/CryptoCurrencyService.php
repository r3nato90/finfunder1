<?php

namespace App\Services\Trade;

use App\Enums\Trade\CryptoCurrencyStatus;
use App\Enums\Trade\TradeVolume;
use App\Models\CryptoCurrency;
use App\Services\Api\CoinGeckoService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class CryptoCurrencyService
{

    /**
     * @param int|string $id
     * @return CryptoCurrency|null
     */
    public function findById(int|string $id): ?CryptoCurrency
    {
        return CryptoCurrency::find($id);
    }


    /**
     * @param string $pair
     * @return CryptoCurrency|null
     */
    public function findByPair(string $pair): ?CryptoCurrency
    {
        return CryptoCurrency::where('crypto_id', $pair)->first();
    }


    public function getCryptoCurrencyByPaginate()
    {
        return CryptoCurrency::filter(request()->all())->paginate(getPaginate());
    }


    public function getTopCrypto()
    {
        return CryptoCurrency::take(10)->get();
    }

    /**
     * @param array $data
     * @return array
     */
    public function prepParams(array $data): array
    {
        $file = Arr::get($data, 'image', '');

        return [
            'name' => Arr::get($data, 'name', ''),
            'pair' => strtoupper(Arr::get($data, 'symbol', '')).'/'.'USDT',
            'crypto_id' => Arr::get($data, 'id', ''),
            'symbol' => Arr::get($data, 'symbol', ''),
            'file' => is_array($file) ? Arr::get($file, 'large') : $file,
            'meta' => [
                'current_price' => Arr::get($data, 'current_price', ''),
                'market_cap' => Arr::get($data, 'market_cap', ''),
                'total_volume' => Arr::get($data, 'total_volume', ''),
                'high_24h' => Arr::get($data, 'high_24h', ''),
                'low_24h' => Arr::get($data, 'low_24h', ''),
                'price_change_24h' => Arr::get($data, 'price_change_24h', ''),
                'market_cap_change_24h' => Arr::get($data, 'market_cap_change_24h', ''),
                'total_supply' => Arr::get($data, 'total_supply', ''),
            ],
            'status' => CryptoCurrencyStatus::ACTIVE->value,
        ];
    }

    /**
     *
     * @param array $params
     * @return CryptoCurrency
     */
    public function save(array $params): CryptoCurrency
    {
        return CryptoCurrency::updateOrCreate(
            ['crypto_id' => Arr::get($params, 'crypto_id')],
            $params
        );
    }

    /**
     * @param array $with
     * @return Collection
     */
    public function getActiveCoinReport(array $with = []): Collection
    {
        return CryptoCurrency::with($with)
            ->where('status', CryptoCurrencyStatus::ACTIVE->value)
            ->selectRaw('
            *,
            (SELECT COALESCE(SUM(amount), 0) FROM trade_logs WHERE crypto_currency_id = crypto_currencies.id) as total_trading_amount,
            (SELECT COALESCE(SUM(amount), 0) FROM trade_logs WHERE crypto_currency_id = crypto_currencies.id AND volume = ?) as high_volume,
            (SELECT COALESCE(SUM(amount), 0) FROM trade_logs WHERE crypto_currency_id = crypto_currencies.id AND volume = ?) as low_volume
        ', [TradeVolume::HIGH->value, TradeVolume::LOW->value])
            ->get();
    }

    /**
     * @param array $with
     * @return Collection
     */
    public function getActiveCryptoCurrency(array $with = []): Collection
    {
        return CryptoCurrency::with($with)
            ->where('status', CryptoCurrencyStatus::ACTIVE->value)
            ->get();
    }

    public function getActiveCryptoCurrencyByPaginate()
    {
        return CryptoCurrency::where('status', CryptoCurrencyStatus::ACTIVE->value)->paginate(getPaginate());
    }

    public function getTopGainerLoser(): void
    {
        $coinGeckoService = app(CoinGeckoService::class);
        $crypto  = $coinGeckoService->getTopGainerLoser();

        $this->cryptoUpdate(array_slice($crypto, 0, 10), 'top_gainer');
        $this->cryptoUpdate(array_slice($crypto, -10, 10), 'top_loser');
    }

    protected function cryptoUpdate(array $crypto, string $key): void
    {
        $x = 1;
        foreach ($crypto as $value){
            $params = $this->prepParams($value);
            $params[$key] = $x;
            $this->save($params);
            $x++;
        }
    }

}
