<?php

use App\Enums\Theme\ThemeName;
use App\Enums\Theme\ThemeType;
use App\Enums\Theme\ThemeAsset;
use App\Enums\Theme\FileType;
use App\Models\EmailSmsTemplate;
use App\Models\Setting;
use App\Services\SettingService;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

    if (!function_exists('slug')) {
        /**
         * @param string|null $string
         * @return string
         */
        function slug(string $string = null): string
        {
            return Str::slug($string);
        }
    }

    if(!function_exists('randomGenerateNumber')){
        function randomGenerateNumber(): int
        {
            return mt_rand(1,10000000);
        }
    }

    if (!function_exists('showDateTime')) {
        /**
         * @param string|null $date
         * @param string $format
         * @return string
         */
        function showDateTime(string $date = null, string $format = 'Y-m-d h:i A'): string
        {
            return Carbon::parse($date)->format($format);
        }
    }

    if (!function_exists('diffForHumans')) {
        /**
         * @param string|null $date
         * @return string
         */
        function diffForHumans(string $date = null): string
        {
            return Carbon::parse($date)->diffForHumans();
        }
    }

    if (!function_exists('carbon')) {
        /**
         * @param string|null $date
         * @param string $timezone
         * @return Carbon
         */
        function carbon(string $date = null, string $timezone = 'UTC'): Carbon
        {
            if (!$date) {
                return Carbon::now($timezone);
            }

            return (new Carbon($date, $timezone));
        }
    }

    if (!function_exists('str_limit')) {
        /**
         * @param $title
         * @param int $length
         * @return string
         */
        function str_limit($title = null, int $length = 10): string
        {
            return Str::limit($title, $length);
        }
    }

    if (!function_exists('shortAmount')) {
        /**
         * @param float|int|string|null $amount
         * @return string|bool
         */
        function shortAmount(float|int|string|null $amount = null): string|bool
        {
            if ($amount !== null) {
                $amount = (float) $amount;
            }
            return (string) round($amount,2);
        }
    }

    if (!function_exists('getAmount')) {
        /**
         * @param float|int|string|null $amount
         * @return string|bool
         */
        function getAmount(float|int|string|null $amount = null): string|bool
        {
            if ($amount !== null) {
                $amount = (float) $amount;
            }
            return round($amount, 2);
        }
    }

    if (!function_exists('getFileSize')) {
        /**
         * @return array
         */
        function getFileSize(): array
        {
            return [
                'profile' => [
                    'admin' => '400x400',
                    'user' => '400x400',
                ],
                'meta_image' => '600x330',
                'favicon' => '128x128',
                'payment' => '800x800',
                'crypto' => '600x600',
                'withdraw' => '600x600',
            ];
        }
    }

    if (!function_exists('getThemeFiles')) {
        function getThemeFiles(ThemeType $themeType, FileType $fileType): array
        {
            $themeFiles = [
                ThemeType::USER->value => [
                    FileType::CSS->value => [
                        'main.css',
                    ],
                    FileType::JS->value => [
                        'script.js'
                    ]
                ],
                ThemeType::INSTALLER->value => [
                    FileType::CSS->value => [
                        'style.css',
                    ],
                ],
                ThemeType::FRONTEND->value => [
                    ThemeName::DEFAULT_THEME->value => [
                        FileType::CSS->value => [
                            'aos.css',
                            'flag-icons.css',
                            'odometer.css',
                            'jquery.fancybox.min.css',
                            'main.css',
                        ],
                        FileType::JS->value => [
                            'viewport.jquery.js',
                            'aos.js',
                            'jquery.fancybox.min.js',
                            'odometer.min.js',
                            'gsap.min.js',
                            'cursor.js',
                            'jquery.marquee.min.js',
                            'main.js',
                        ]
                    ],
                    ThemeName::BLUE_THEME->value => [
                        FileType::CSS->value => [
                            'flag-icons.css',
                            'remix-icon.css',
                            'simpler-bar.min.css',
                            'venobox.min.css',
                            'main.css',
                        ],
                        FileType::JS->value => [
                            'aos.js',
                            'jquery.marquee.min.js',
                            'app.js',
                            'venobox.js'
                        ]
                    ]
                ],
                ThemeType::AUTH->value => [
                    FileType::CSS->value => [
                        'aos.css',
                        'flag-icons.css',
                        'odometer.css',
                        'jquery.fancybox.min.css',
                        'main.css',
                    ],
                    FileType::JS->value => [
                        'viewport.jquery.js',
                        'aos.js',
                        'jquery.fancybox.min.js',
                        'odometer.min.js',
                        'gsap.min.js',
                        'cursor.js',
                        'jquery.marquee.min.js',
                        'main.js',
                    ]
                ],
                ThemeType::ADMIN->value => [
                    FileType::CSS->value => [
                        'style.css',
                        'simple-bar.css',
                        'responsive.css',
                        'summernote-lite.min.css',
                        'spectrum.css',
                    ],
                    FileType::JS->value => [
                        'ckd.js',
                        'simple-bar.min.js',
                        'script.js',
                        'summernote-lite.min.js',
                        'spectrum.js'
                    ]
                ],
                ThemeType::GLOBAL->value => [
                    FileType::CSS->value => [
                        'bootstrap.min.css',
                        'line-awesome.min.css',
                        'bootstrap-icons.min.css',
                        'select2.min.css',
                        'toaster.css',
                        'swiper-bundle.min.css',
                        'apexcharts.css',
                        'datepicker.min.css',
                    ],
                    FileType::JS->value => [
                        'jquery-3.7.1.min.js',
                        'bootstrap.bundle.min.js',
                        'select2.min.js',
                        'toaster.js',
                        'swiper-bundle.min.js',
                        'apexcharts.js',
                        'datepicker.min.js',
                        'datepicker.en.js',
                    ]
                ],
            ];

            if ($themeType->value == ThemeType::FRONTEND->value){
                $activeTheme = getActiveTheme();
                $themeFiles = $themeFiles[$themeType->value][$activeTheme][$fileType->value] ?? [];
            }else{
                $themeFiles = $themeFiles[$themeType->value][$fileType->value] ?? [];
            }

            return $themeFiles;
        }
    }

    if (!function_exists('getAssetPath')) {
        function getAssetPath(ThemeAsset $themeType, FileType $fileType, string $fileName): string
        {
            $themeType = $themeType->value;

            if($themeType == ThemeAsset::FRONTEND->value){
                $themeType= $themeType.'/'.getActiveTheme();
            }

            return asset("{$themeType}/{$fileType->value}/{$fileName}");
        }
    }


    if (!function_exists('getActiveTheme')) {
        function getActiveTheme(): string
        {
            $setting = SettingService::getSetting();
            return (string)getArrayValue($setting->theme_template_setting, 'currently_active', 'default_theme') ?? 'default_theme';

        }
    }

    if (!function_exists('getInputName')) {
        /**
         * @param $text
         * @return string
         */
        function getInputName($text): string
        {
            return strtolower(str_replace(' ', '_', $text));
        }
    }

    if (!function_exists('calculateCommissionCut')) {
        /**
         * @param int|float|string $amout
         * @param int|float|string $charge
         * @return float|int|string
         */
        function calculateCommissionCut(int|float|string $amout, int|float|string $charge = 0): float|int|string
        {
            return ($amout - ($amout * $charge) / 100);
        }
    }

    if (!function_exists('calculateCommissionPlus')) {
        /**
         * @param int|float|string $amout
         * @param int|float|string $charge
         * @return float|int|string
         */
        function calculateCommissionPlus(int|float|string $amout, int|float|string $charge = 0): float|int|string
        {
            return ($amout + ($amout * $charge) / 100);
        }
    }

    if (!function_exists('getFilePath')) {
        /**
         *
         * @return string
         */
        function getFilePath(): string
        {
            return asset('assets/files');
        }
    }

    if (!function_exists('displayImage')) {
        /**
         * @param string|null $fileName
         * @param string|null $size
         * @return string
         */
        function displayImage(?string $fileName, ?string $size = "1980x1080"): string
        {
            $filePath = 'assets/files/' . $fileName;


            if(is_null($fileName) || blank($fileName)){
                return route('default.image', $size);
            }

            if (file_exists($filePath)) {
                return asset('assets/files/' . $fileName);
            }

            if ($size) {
                return route('default.image', $size);
            }

            return asset('assets/files/default.jpg');
        }

    }

    if (!function_exists('getCountryList')) {
        /**
         * @return array
         */
        function getCountryList(): array
        {
            return \Illuminate\Support\Facades\File::json(resource_path('data/country.json'));
        }
    }


    if (!function_exists('findCountryByCode')) {
        /**
         * @param string $code
         * @return array|null
         */
        function findCountryByCode(string $code): ?array
        {
            $countryList = getCountryList();
            $countryInfo = collect($countryList)->firstWhere('code', $code);

            return $countryInfo ?: null;
        }
    }

    if (!function_exists('getArrayValue')) {
        /**
         * @param array|null $array
         * @param string|null $key
         * @param string $default
         * @return string|array|null
         */
        function getArrayValue(?array $array, ?string $key = null, string $default = ''): string|array|null
        {
            $array = is_null($array) ? [] : $array;

            if (is_array($array)){
                return \Illuminate\Support\Arr::get($array, $key, $default) ?? '';
            }else{
                return  null;
            }
        }
    }

    if (!function_exists('replaceInputTitle')) {
        /**
         * @param $text
         * @return string
         */
        function replaceInputTitle($text): string
        {
            return ucwords(preg_replace("/[^A-Za-z0-9 ]/", ' ', $text));
        }
    }

    if (!function_exists('negative_value')) {
        /**
         * @param int|float $value
         * @param bool $float
         * @return int|float
         */
        function negative_value(int|float $value, bool $float = false): int|float{
            if ($float) {
                $value = (float) $value;
            }

            return 0 - abs($value);
        }
    }

    if (!function_exists('getTrx')) {
        /**
         * @param int $length
         * @return string
         */
        function getTrx(int $length = 12): string
        {
            $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }
    }

    if (!function_exists('text_replacer')) {
        /**
         * @param string $text
         * @param array $data
         * @return string
         */
        function text_replacer(string $text, array $data): string
        {
            if (array_is_list($data)) {
                return $text;
            }

            $replacer = [];

            foreach ($data as $key => $value) {
                $replacer['['. strtolower($key) .']'] = $value;
            }

            return strtr($text, $replacer);
        }
    }

    if (!function_exists('mail_content')) {
        /**
         * @param string $code
         * @return array|string[]
         */
        function mail_content(string $code): array
        {
            $setting = \App\Services\SettingService::getSetting();
            $template = EmailSmsTemplate::where('code', $code)->first();

            if(!$template) {
                return [
                    'subject' => '',
                    'sms_content' => '',
                    'email_content' => '',
                ];
            }
            return [
                'subject' => $template->subject,
                'sms_content' => $setting->sms_template.' '.$template->sms_template,
                'email_content' => $setting->mail_template.' '.$template->mail_template,
            ];
        }
    }


    function hex2rgba($color, $opacity ): string
    {
        list($r, $g, $b) = sscanf($color, "#%02x%02x%02x");
        return "rgba($r, $g, $b, $opacity)";

    }

    if (!function_exists('getPaginate')) {
        /**
         * @param int $perPage
         * @return int
         */
        function getPaginate(int $perPage = 20): int
        {
            return $perPage;
        }
    }

    if (!function_exists('getCurrencyName')) {
        /**
         * @return string
         */
        function getCurrencyName(): string
        {
            $setting = Setting::first();
            $appearance = $setting->appearance ?? [];
            return getArrayValue($appearance, 'currency_code', 'USD');
        }
    }

    if (!function_exists('getCurrencySymbol')) {
        /**
         * @return string
         */
        function getCurrencySymbol(): string
        {
            $setting = \App\Services\SettingService::getSetting();
            return getArrayValue($setting->appearance, 'currency_symbol', '$');
        }
    }

    if (!function_exists('getSiteTitle')) {
        /**
         * @return string
         */
        function getSiteTitle(): string
        {
            $setting = \App\Services\SettingService::getSetting();
            return getArrayValue($setting->appearance, 'site_title', '');
        }
    }


    if (!function_exists('calculateTime')) {
        /**
         * @param int $time
         * @param string $unit
         * @return string
         */
        function calculateTime(int $time, string $unit): string
        {
            $currentTime = Carbon::now();

            return match ($unit) {
                App\Enums\Trade\TradeParameterUnit::MINUTES->value => $currentTime->addMinutes($time)->format('H:i:s'),
                App\Enums\Trade\TradeParameterUnit::HOURS->value => $currentTime->addHours($time)->format('H:i:s'),
                default => throw new InvalidArgumentException('Unsupported time unit: ' . $unit),
            };
        }
    }


    if (!function_exists('totalInvestmentInterest')) {

        function totalInvestmentInterest(\App\Models\InvestmentPlan $investmentPlan): string
        {
            $interestAmount = 0;
            $capital = '';
            if ($investmentPlan->recapture_type == \App\Enums\Investment\Recapture::YES->value) {
                $interestAmount = $investmentPlan->interest_rate * $investmentPlan->duration;
                $capital = ' + capital';
            } elseif ($investmentPlan->recapture_type == \App\Enums\Investment\Recapture::NO->value) {
                $interestAmount = $investmentPlan->interest_rate * $investmentPlan->duration;
            }elseif ($investmentPlan->recapture_type == \App\Enums\Investment\Recapture::HOLD->value) {
                $interestAmount = $investmentPlan->interest_rate * $investmentPlan->duration;
                $capital = ' + capital';
            }

            return shortAmount($interestAmount) . ($investmentPlan->interest_type == \App\Enums\Investment\InterestType::PERCENT->value ? '%' : ' ' . getCurrencyName()) . $capital;

        }
    }


    if (!function_exists('cryptoQRCode')) {
        function cryptoQRCode(string $wallet): string
        {
            return "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$wallet&choe=UTF-8";
        }
    }


    if (!function_exists('paginateMeta')) {

        function paginateMeta($paginate): array
        {
            return [
                'current_page' => $paginate->currentPage(),
                'first_page_url' => $paginate->url(1),
                'from' => $paginate->firstItem(),
                'next_page_url' => $paginate->nextPageUrl(),
                'path' => $paginate->path(),
                'per_page' => $paginate->perPage(),
                'prev_page_url' => $paginate->previousPageUrl(),
                'to' => $paginate->lastItem(),
            ];
        }
    }

    if (!function_exists('getCryptoOptions')) {
        function getCryptoOptions(): array
        {
            return [
                'btc' => 'BTC',
                'btg' => 'BTG',
                'eth' => 'ETH',
                'xmr' => 'XMR',
                'zec' => 'ZEC',
                'xvg' => 'XVG',
                'ada' => 'ADA',
                'ltc' => 'LTC',
                'bch' => 'BCH',
                'qtum' => 'QTUM',
                'dash' => 'DASH',
                'xlm' => 'XLM',
                'xrp' => 'XRP',
                'xem' => 'XEM',
                'dgb' => 'DGB',
                'lsk' => 'LSK',
                'doge' => 'DOGE',
                'trx' => 'TRX',
                'kmd' => 'KMD',
                'rep' => 'REP',
                'bat' => 'BAT',
                'ark' => 'ARK',
                'waves' => 'WAVES',
                'bnb' => 'BNB',
                'xzc' => 'XZC',
                'nano' => 'NANO',
                'tusd' => 'TUSD',
                'vet' => 'VET',
                'zen' => 'ZEN',
                'grs' => 'GRS',
                'fun' => 'FUN',
                'neo' => 'NEO',
                'gas' => 'GAS',
                'pax' => 'PAX',
                'usdc' => 'USDC',
                'ont' => 'ONT',
                'xtz' => 'XTZ',
                'link' => 'LINK',
                'rvn' => 'RVN',
                'bnbmainnet' => 'BNB Mainnet',
                'zil' => 'ZIL',
                'bcd' => 'BCD',
                'usdt' => 'USDT',
                'usdterc20' => 'USDT ERC20',
                'cro' => 'CRO',
                'dai' => 'DAI',
                'ht' => 'HT',
                'wabi' => 'WABI',
                'busd' => 'BUSD',
                'algo' => 'ALGO',
                'usdttrc20' => 'USDT TRC20',
                'gt' => 'GT',
                'stpt' => 'STPT',
                'ava' => 'AVA',
                'sxp' => 'SXP',
                'uni' => 'UNI',
                'okb' => 'OKB',
            ];
        }
    }


    if (!function_exists('getCryptoPrice')) {
        /**
         * Fetch cryptocurrency price from Binance API.
         * @param string $symbol The trading pair symbol (e.g., BTCUSDT, ETHUSDT).
         * @return float|null The price of the cryptocurrency, or null if the request fails.
         */
        function getCryptoPrice(string $symbol): ?float
        {
            $url = 'https://api.binance.com/api/v3/ticker/price';
            try {
                $response = Http::get($url, ['symbol' => strtoupper($symbol).'USDT']);
                if ($response->successful()) {
                    $data = $response->json();
                    return isset($data['price']) ? (float) $data['price'] : null;
                }
            } catch (\Exception $e) {
                return null;
            }

            return null;
        }
    }



