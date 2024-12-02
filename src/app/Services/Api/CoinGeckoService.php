<?php

namespace App\Services\Api;

use App\Models\CryptoCurrency;
use App\Services\Trade\CryptoCurrencyService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Arr;

class CoinGeckoService
{
    protected Client $client;
    protected string $baseUrl = 'https://api.coingecko.com/api/v3/';
    public function __construct(protected CryptoCurrencyService $cryptoCurrencyService)
    {
        $this->client = new Client();
    }

    /**
     * @throws GuzzleException
     */
    public function getCryptoPricesToFlat(string $cryptoId)
    {
        $response = $this->client->get($this->baseUrl . 'simple/price', [
            'query' => [
                'ids' => $cryptoId,
                'vs_currencies' => implode(',', array_keys($this->getFlatCurrency())),
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * @param int $limit
     * @return array|null
     * @throws GuzzleException
     */
    public function getTopCryptoCurrencies(int $limit = 50): ?array
    {
        try {
            $response = $this->client->get($this->baseUrl . 'coins/markets', [
                'query' => [
                    'vs_currency' => 'usd',
                    'order' => 'market_cap_desc',
                    'per_page' => $limit,
                    'page' => 1,
                    'sparkline' => false,
                ],
            ]);

            return json_decode($response->getBody(), true);

        } catch (\Exception $exception){

            return null;
        }
    }


    /**
     * @param int $limit
     * @return array|null
     */
    public function getTopGainerLoser(int $limit = 50): ?array
    {
        try {
            $response = $this->client->get($this->baseUrl . 'coins/markets', [
                'query' => [
                    'vs_currency' => 'usd',
                    'order' => 'percent_change_24h',
                    'per_page' => $limit,
                    'page' => 1,
                    'sparkline' => false,
                ],
            ]);

            return json_decode($response->getBody(), true);

        } catch (GuzzleException $exception){

            return null;
        }
    }

    /**
     * @throws GuzzleException
     */
    public function getCoinByName(string $name)
    {
        $response = $this->client->get($this->baseUrl . "coins/{$name}");
        return json_decode($response->getBody(), true);
    }

    /**
     * @throws GuzzleException
     */
    public function getCoinRate(CryptoCurrency $cryptoCurrency)
    {
        $response = $this->client->get($this->baseUrl . 'simple/price', [
            'query' => [
                'ids' => $cryptoCurrency->crypto_id,
                'vs_currencies' => 'usd'
            ],
        ]);

        $data =  json_decode($response->getBody(), true);
        return Arr::get($data, $cryptoCurrency->crypto_id.'.'.'usd');
    }

    public function getFlatCurrency(): array
    {
        return include resource_path('data/currency_codes.php');
    }

}
