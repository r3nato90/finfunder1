<?php

namespace App\Console\Commands;

use App\Models\CryptoCurrency;
use App\Services\Api\CoinGeckoService;
use App\Services\Trade\CryptoCurrencyService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

class CryptoCurrencyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:crypto-currency';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crypto Currency updated';

    /**
     * Execute the console command.
     * @throws GuzzleException
     */
    public function handle(CoinGeckoService $coinGeckoService, CryptoCurrencyService $cryptoCurrencyService): void
    {
        if (CryptoCurrency::count() === 0) {
            $this->cryptoSave($cryptoCurrencyService, $coinGeckoService);
        }

        $cryptoCurrencyService->getTopGainerLoser();
        $this->info("Crypto-Currency Job is being processed");
    }

    /**
     * @throws GuzzleException
     */
    protected function cryptoSave(CryptoCurrencyService $cryptoCurrencyService, CoinGeckoService $coinGeckoService): void
    {
        foreach ($coinGeckoService->getTopCryptoCurrencies(100) as $value){
            $cryptoCurrencyService->save($cryptoCurrencyService->prepParams($value));
        }
    }
}
