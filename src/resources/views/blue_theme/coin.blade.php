@extends(getActiveTheme().'.layouts.main')
@section('content')
    @include(getActiveTheme().'.partials.breadcrumb')
    <div class=" pt-120 pb-120">
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
    @include(getActiveTheme().'.component.currency_exchange')
    @include(getActiveTheme().'.component.service')
@endsection


