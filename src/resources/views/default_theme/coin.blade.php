@extends(getActiveTheme().'.layouts.main')
@section('content')
    @include(getActiveTheme().'.partials.breadcrumb')
    <div class="all-coin-graph pt-110 pb-110">
        <div class="container">
            <div class="tradingview-widget-container" style="height:100%;width:100%">
                <div id="technical-analysis-chart-demo" style="height:450px;width:100%"></div>
                <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
                <script type="text/javascript">
                    new TradingView.widget(
                        {
                            "container_id": "technical-analysis-chart-demo",
                            "width": "100%",
                            "autosize": true,
                            "symbol": "BTC",
                            "interval": "D",
                            "timezone": "exchange",
                            "theme": "light",
                            "style": "1",
                            "withdateranges": true,
                            "hide_side_toolbar": false,
                            "allow_symbol_change": true,
                            "save_image": false,
                            "studies": [
                                "ROC@tv-basicstudies",
                                "StochasticRSI@tv-basicstudies",
                                "MASimple@tv-basicstudies"
                            ],
                            "show_popup_button": true,
                            "popup_width": "1000",
                            "popup_height": "650",
                            "support_host": "https://www.tradingview.com",
                            "locale": "en"
                        }
                    );
                </script>
            </div>
        </div>
    </div>
    @include(getActiveTheme().'.component.crypto_pairs')
    <div class="all-coin-section pt-110 pb-110">
        <div class="container-fluid padding-left-right">
            <div class="nav-style-three">
                <ul class="nav nav-tabs d-flex flex-row mb-40" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#tab-one" aria-selected="false" role="tab" tabindex="-1">{{ __('All') }}</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link " data-bs-toggle="tab" href="#tab-two" aria-selected="true" role="tab">{{ __('Top Gainer') }}</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab-three" aria-selected="true" role="tab" tabindex="-1">{{ __('Top Looser') }}</a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active show" id="tab-one" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-container">
                                    @include(getActiveTheme().'.partials.cryptos', ['currencyExchanges' => $cryptos])
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">{{ $cryptos->links() }}</div>
                    </div>
                    <div class="tab-pane fade" id="tab-two" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-container">
                                    @include(getActiveTheme().'.partials.cryptos', ['currencyExchanges' => $topGainers])
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-three">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-container">
                                    @include(getActiveTheme().'.partials.cryptos', ['currencyExchanges' => $topLosers])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


