@extends('admin.layouts.main')
@section('panel')
<section>
    <div class="container-fluid px-0">
        <div class="row gy-4 mb-4">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4 class="card-title mb-0">{{ __('admin.report.statistics.trade.four') }}</h4>
                    </div>
                    <div class="card-body">
                        <div id="totalTrade" class="charts-height"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card card-height-100">
                    <div class="card-body">
                        <div class="card linear-card bg--linear-primary text-center mb-2">
                            <div class="icon">
                                <i class="las la-wallet"></i>
                            </div>
                            <div class="card-body p-3">
                                <h6 class="text-white opacity-75 fw-normal fs-14">{{ __('admin.report.statistics.trade.one.total') }}</h6>
                                <h4 class="fw-bold mt-1 mb-2 text-white">{{ getCurrencySymbol() }}{{ shortAmount($trade->total) }}</h4>
                            </div>
                        </div>
                        <ul class="d-flex flex-column gap-2">
                            @foreach (['today', 'wining', 'loss', 'draw', 'high', 'low'] as $key)
                                <li class="p-3 d-flex bg--light">
                                    <div class="flex-grow-1 d-flex align-items-center gap-3">
                                        <h5 class="text--light fs-14">{{ __("admin.report.statistics.trade.one.{$key}") }}</h5>
                                    </div>
                                    <div class="flex-shrink-0 text-end">
                                        <h5 class="text--dark fw-bold fs-14">{{ getCurrencySymbol() }}{{ shortAmount($trade->$key) }}</h5>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">{{ __("admin.report.statistics.trade.two") }}</h4>
                        <a href="{{ route('admin.trade.index') }}" class="text--muted text-decoration-underline">{{ __('admin.button.view') }}</a>
                    </div>
                    <div class="card-body">
                        <div class="swiper trade-card-slider">
                            <div class="swiper-wrapper">
                                @forelse($latestTradeLogs as $latestTradeLog)
                                    <div class="swiper-slide">
                                        <div class="custom--border bg--icon">
                                            <div class="icon">
                                                <i class="las la-arrow-circle-down text--success"></i>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center py-2 border--bottom-dash">
                                                    <h6 class="fs-13 fw-bold text--dark">{{ __('admin.table.coin') }}</h6>
                                                    <img src="{{ $latestTradeLog?->cryptoCurrency->file }}" class="avatar--sm" alt="{{ $latestTradeLog?->cryptoCurrency->name }}">
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center py-2 border--bottom-dash">
                                                    <h6 class="fs-13 fw-bold text--dark">{{ __('admin.table.created_at') }}</h6>
                                                    <p class="mb-0 fs-13 text--light">{{ showDateTime($latestTradeLog->created_at) }}</p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center py-2 border--bottom-dash">
                                                    <h6 class="fs-13 fw-bold text--dark">{{ __('admin.table.user') }}</h6>
                                                    <p class="mb-0 fs-13 text--light">{{ $latestTradeLog->user?->email }}</p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center py-2 border--bottom-dash">
                                                    <h6 class="fs-13 fw-bold text--dark">{{ __('admin.table.amount') }}</h6>
                                                    <p class="mb-0 fs-13 text--light">{{ getCurrencySymbol() }}{{ shortAmount($latestTradeLog->amount) }}</p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center py-2 border--bottom-dash">
                                                    <h6 class="fs-13 fw-bold text--dark">{{ __('admin.table.outcome') }}</h6>
                                                    <p class="mb-0 fs-13 text--light">
                                                        <span class="badge {{ \App\Enums\Trade\TradeOutcome::getColor($latestTradeLog->outcome) }}">{{ \App\Enums\Trade\TradeOutcome::getName($latestTradeLog->outcome) }}</span>
                                                    </p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center py-2 border--bottom-dash">
                                                    <h6 class="fs-13 fw-bold text--dark">{{ __('admin.table.volume') }}</h6>
                                                    <p class="mb-0 fs-13 text--light">
                                                        <span class="badge {{ \App\Enums\Trade\TradeVolume::getColor($latestTradeLog->volume) }}">{{ \App\Enums\Trade\TradeVolume::getName($latestTradeLog->volume) }}</span>
                                                    </p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center pt-2">
                                                    <h6 class="fs-13 fw-bold text--dark">{{ __('admin.table.status') }}</h6>
                                                    <p class="mb-0 fs-13 text--light">
                                                        <span class="badge {{ \App\Enums\Trade\TradeStatus::getColor($latestTradeLog->status) }}">{{ \App\Enums\Trade\TradeStatus::getName($latestTradeLog->status) }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-muted">{{ __('No Data Found') }}</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center">
                        <h4 class="card-title mb-0">{{ __("admin.report.statistics.trade.three") }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="swiper plan-card-slider">
                                    <div class="swiper-wrapper">
                                        @foreach($coins as $coin)
                                            <div class="swiper-slide">
                                                <a href="{{ route('admin.report.trade.crypto', $coin->id) }}" class="card card--design">
                                                    <div class="card-body">
                                                        <div class="row align-items-start g-3">
                                                            <div class="col-6">
                                                                <div class="d-flex align-items-center">
                                                                    <img src="{{ $coin->file }}" class="avatar--sm" alt="{{ $coin->name }}">
                                                                    <h6 class="ms-2 mb-0 fs-14 text--dark">{{ __($coin->name) }}</h6>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 text-end">
                                                                <p class="fs-13 fw-normal text--light">{{ __('admin.table.trading_amount') }}</p>
                                                                <h6 class="fs-14">{{ getCurrencySymbol() }}{{ shortAmount($coin->total_trading_amount) }}</h6>
                                                            </div>
                                                            <div class="col-6 text-start">
                                                                <h6 class="fs-14 text--success"><i class="las la-arrow-up text--success fs-14 me-2"></i>{{ getCurrencySymbol() }}{{ shortAmount($coin->high_volume) }}</h6>
                                                            </div>
                                                            <div class="col-6 text-end">
                                                                <h6 class="fs-14 text--danger"><i class="las la-arrow-down text--danger fs-14 me-2"></i>{{ getCurrencySymbol() }}{{ shortAmount($coin->low_volume) }}</h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('script-push')
    <script>
        "use strict";
        $(document).ready(function () {
            const amount = @json($amount);
            const days = @json($days);
            const currency = "{{ getCurrencySymbol() }}";
            const content = "{{ __('admin.report.statistics.trade.five') }}"
            const tradeContent = "{{ __('Trade Amount') }}";

            const options = {
                series: [{
                    name: tradeContent,
                    data: amount
                }],
                chart: {
                    type: 'bar',
                    height: 400,
                    toolbar: false
                },

                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '50%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: days,
                },
                yaxis: {
                    title: {
                        text: content
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return currency + val
                        }
                    }
                }
            };
            const chart = new ApexCharts(document.querySelector("#totalTrade"), options);
            chart.render();
        });
    </script>
@endpush
