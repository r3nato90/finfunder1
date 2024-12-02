@if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::TRADE_PREDICTION->name)) == 1)
    @php
        $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::CURRENCY_EXCHANGE, \App\Enums\Frontend\Content::FIXED);
    @endphp
    <section class="bg--light pt-120 pb-120">
        <div class="container-fluid container-wrapper">
            <div class="section-title title-fluid">
                <div class="title-left">
                    <h2 class="mb-0">{{ getArrayValue($fixedContent?->meta, 'heading') }}</h2>
                </div>

                <div class="title-right">
                    <p>{{ getArrayValue($fixedContent?->meta, 'sub_heading') }}</p>
                    <a href="{{ route('trade') }}" class="i-btn btn--primary btn--lg pill w-fit-content">{{ __('Explore Trades') }}</a>
                </div>
            </div>
            @include(getActiveTheme().'.partials.blue_cryptos', ['currencyExchanges' => $currencyExchanges])
        </div>
    </section>
@endif


