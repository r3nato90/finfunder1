@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="container-fluid px-0">
            <div class="row mb-4 gy-4">
                <div class="col-xxl-4 col-xl-5">
                    <div class="card">
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

                <div class="col-xxl-8 col-xl-7">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4 class="card-title mb-0">{{ __('admin.report.statistics.investment.one') }}</h4>
                        </div>
                        <div class="card-body">
                            <div id="investProfitChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gy-4 mb-4">
            <div class="col-xxl-8 col-xl-7">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4 class="card-title mb-0">{{ __('admin.report.statistics.trade.four') }}</h4>
                    </div>
                    <div class="card-body">
                        <div id="totalTrade"></div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-4 col-xl-5">
                <div class="card h-100">
                    <div class="card-body">
                        <ul class="list-group list-group-flush border-dashed mb-0">
                            @php
                                $investments = [
                                    'today_invest' => ['wallet text--primary', 'admin.dashboard.content.invest.today_invest'],
                                    'running' => ['wallet text--primary', 'admin.dashboard.content.invest.running'],
                                    'profit' => ['chart-line text--success', 'admin.dashboard.content.invest.profit'],
                                    'closed' => ['comment-dollar text--warning', 'admin.dashboard.content.invest.closed'],
                                    're_invest' => ['sort-amount-up text--info', 'admin.dashboard.content.invest.re_invest'],
                                ];
                            @endphp
                            @foreach($investments as $key => $details)
                                <li class="list-group-item px-0">
                                    <div class="d-flex">
                                        <div class="flex-grow-1 d-flex align-items-center gap-3">
                                            <i class="las la-{{ $details[0] }} fs-24"></i>
                                            <h5 class="text--light fs-15">{{ __($details[1]) }}</h5>
                                        </div>
                                        <div class="flex-shrink-0 text-end">
                                            <h5 class="text--dark fw-bold">{{ getCurrencySymbol() }}{{ shortAmount($investment->$key) }}</h5>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
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
            const currency = "{{ getCurrencySymbol() }}";
            const invest = @json($invest);
            const profit = @json($profit);
            const months = @json($months);

            const investmentOptions = {
                series: [{
                    name: 'Profit',
                    data: profit
                }, {
                    name: 'Invest',
                    data: invest
                }],
                chart: {
                    height: 400,
                    type: 'area'
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    type: 'date',
                    categories: months
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return currency + val
                        }
                    }
                }
            };

            const investmentProfit = new ApexCharts(document.querySelector("#investProfitChart"), investmentOptions);
            investmentProfit.render();



            const amount = @json($amount);
            const days = @json($days);
            const content = "{{ __('admin.report.statistics.trade.five') }}"

            const options = {
                series: [{
                    name: 'Investment',
                    data: amount
                }],
                chart: {
                    type: 'bar',
                    height: 300,
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
