@extends('layouts.user')
@section('content')
    <div class="main-content" data-simplebar>
        <div class="row g-4 mb-4">
            <div class="col-lg-4">
                <div class="i-card-sm p-3">
                    <div class="i-card-sm card-style rounded-3">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="title text--purple mb-4">{{ __('frontend.dashboard.investment.index') }}</h5>
                            <div class="avatar--lg bg--primary">
                                <i class="bi bi-credit-card text-white"></i>
                            </div>
                        </div>

                        <div class="card-info text-center">
                            <ul class="user-card-list w-100">
                                <li class="d-flex align-items-center justify-content-between gap-3 mb-2"><span class="fw-bold">{{ __('frontend.dashboard.investment.total') }}</span>
                                    <span class="fw-bold text--dark">{{ getCurrencySymbol() }}{{ shortAmount($investmentReport->total) }}</span>
                                </li>
                                <li class="d-flex align-items-center justify-content-between gap-3 mb-2"><span class="fw-bold">{{ __('frontend.dashboard.investment.profit') }}</span>
                                    <span class="fw-bold text--dark">{{ getCurrencySymbol() }}{{ shortAmount($investmentReport->profit) }}</span>
                                </li>
                                <li class="d-flex align-items-center justify-content-between gap-3 mb-2"><span class="fw-bold">{{ __('frontend.dashboard.investment.running') }}</span>
                                    <span class="fw-bold text--dark">{{ getCurrencySymbol() }}{{ shortAmount($investmentReport->running) }}</span>
                                </li>
                                <li class="d-flex align-items-center justify-content-between gap-3 mb-2"><span class="fw-bold">{{ __('frontend.dashboard.investment.re_invest') }}</span>
                                    <span class="fw-bold text--dark">{{ getCurrencySymbol() }}{{ shortAmount($investmentReport->re_invest) }}</span>
                                </li>
                                <li class="d-flex align-items-center justify-content-between gap-3"><span class="fw-bold">{{ __('frontend.dashboard.investment.closed') }}</span>
                                    <span class="fw-bold text--dark">{{ getCurrencySymbol() }}{{ shortAmount($investmentReport->closed) }}</span>
                                </li>
                            </ul>
                            <a href="{{ route('user.investment.index') }}" class="btn--white">{{ __('frontend.dashboard.investment.now') }}<i class="bi bi-box-arrow-up-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="i-card-sm">
                    <h5 class="title text--blue mb-4">{{ __('frontend.dashboard.deposit_withdraw.monthly_report') }}</h5>
                    <div id="investProfitChart"></div>
                </div>
            </div>
        </div>

        @if($investmentPlans->isNotEmpty())
            <div class="i-card-sm mb-4">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="swiper plan-card-slider">
                            <div class="swiper-wrapper">
                                @foreach($investmentPlans as $investmentPlan)
                                    <div class="swiper-slide">
                                        <div class="card card--design ">
                                            <div class="card-body">
                                                <div class="row align-items-end g-3">
                                                    <div class="col-8">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar--sm">
                                                                <i class="las la-list-alt fs-24 text--primary"></i>
                                                            </div>
                                                            <h6 class="ms-2 mb-0 fs-14 text--primary">{{ __($investmentPlan->name) }}</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 text-start">
                                                        <p class="fs-13 fw-normal text--light">{{ __('admin.dashboard.content.invest.total_one') }}</p>
                                                        <h6 class="fs-16">{{ getCurrencySymbol() }}{{ shortAmount($investmentPlan->investmentLogs->sum('amount')) }}</h6>
                                                    </div>
                                                    <div class="col-6 text-end">
                                                        <p class="fs-13 fw-normal text--light">{{ __('admin.dashboard.content.invest.profit') }}</p>
                                                        <h6 class="fs-16">{{ getCurrencySymbol() }}{{ shortAmount($investmentPlan->investmentLogs->sum('profit')) }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="i-card-sm">
                    <div class="card-header">
                        <h4 class="title">{{ __($setTitle) }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                @include('user.partials.matrix.commission', [
                                    'commissions' => $profitLogs,
                                    'type' => \App\Enums\CommissionType::INVESTMENT->value,
                                    'route' => route('user.investment.profit.statistics'),
                                ])
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">{{ $profitLogs->links() }}</div>
            </div>
        </div>
    </div>
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
                    height: 255,
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
                    categories: months,
                    labels: {
                        style: {
                            colors: '#ffffff' // Set x-axis labels color to white
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: '#ffffff' // Set y-axis labels color to white
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return currency + val;
                        }
                    }
                }
            };

            const investmentProfit = new ApexCharts(document.querySelector("#investProfitChart"), investmentOptions);
            investmentProfit.render();
        });
    </script>
@endpush
