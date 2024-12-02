@if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::TRADE_PREDICTION->name)) == 1)
    @php
        $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::CURRENCY_EXCHANGE, \App\Enums\Frontend\Content::FIXED);
    @endphp

    <div class="currency-section full--width pt-110 pb-110">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-7 col-md-9">
                    <div class="section-title text-center mb-60">
                        <h2>{{ getArrayValue($fixedContent?->meta, 'heading') }}</h2>
                        <p>{{ getArrayValue($fixedContent?->meta, 'sub_heading') }}</p>
                    </div>
                </div>
            </div>
            <div class="row gy-5">
                <div class="col-lg-12">
                    <div class="currency-wrapper">
                        <div class="text-start">
                            <a href="{{ route('trade') }}" class="i-btn read-more-btn">{{ __('Explore Trades') }} <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    @include(getActiveTheme().'.partials.cryptos', ['currencyExchanges' => $currencyExchanges])
                </div>
            </div>
        </div>
    </div>
@endif
