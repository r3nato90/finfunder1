@extends('admin.layouts.main')
@section('panel')
<section>
    <div class="container-fluid px-0">
        <div class="row gy-4 mb-4">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('admin.report.statistics.matrix.three') }}</h4>
                    </div>
                    <div class="card-body">
                        <div id="matrixChart" class="charts-height"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card card-height-100">
                    <div class="card-body">
                        <div class="card linear-card bg--linear-info text-center mb-2">
                            <div class="icon">
                                <i class="las la-wallet"></i>
                            </div>
                            <div class="card-body p-3">
                                <h6 class="text-white opacity-75 fw-normal fs-14">{{ __('admin.table.total_enrollment') }}</h6>
                                <h4 class="fw-bold mt-1 mb-2 text-white">{{ getCurrencySymbol() }}{{ shortAmount($matrixInvest->total) }}</h4>
                            </div>
                        </div>
                        <ul class="d-flex flex-column gap-2">
                            @foreach (['today', 'referral', 'level', 'commission'] as $key)
                                <li class="py-3 px-3 d-flex bg--light">
                                    <div class="flex-grow-1 d-flex align-items-center gap-3">
                                        <h5 class="text--light fs-14">{{ __("admin.report.statistics.matrix.four.{$key}") }}</h5>
                                    </div>
                                    <div class="flex-shrink-0 text-end">
                                        <h5 class="text--dark fw-bold">{{ getCurrencySymbol() }}{{ shortAmount($matrixInvest->$key) }}</h5>
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
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center">
                        <h4 class="card-title mb-0">{{ __('admin.report.statistics.matrix.two') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="swiper plan-card-slider">
                                    <div class="swiper-wrapper">
                                        @forelse($matrixPlans as $matrixPlan)
                                            <div class="swiper-slide">
                                                <div class="card card--design-2 ">
                                                    <div class="card-body">
                                                        <div class="row g-3">
                                                            <div class="col-8 px-0">
                                                                <div class="d-flex justify-content-start align-items-center">
                                                                    <div class="avatar--sm">
                                                                        <i class="las la-list-alt fs-24 text--primary"></i>
                                                                    </div>
                                                                    <h6 class="ms-2 mb-0 fs-14 text--primary">{{ $matrixPlan->name }}</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mt-3">
                                                            <div class="d-flex justify-content-between align-items-center mb-2 bg-white p-2">
                                                                <p class="fs-14 fw-normal text--light">{{ __('admin.table.enrollment_amount') }}</p>
                                                                <h6 class="fs-14">{{ getCurrencySymbol() }}{{ $matrixPlan->matrixEnrolled->sum('price') }}</h6>
                                                            </div>
                                                            <div class="d-flex justify-content-between align-items-center mb-2 bg-white p-2">
                                                                <p class="fs-14 fw-normal text--light">{{ __('admin.user.content.referral') }}</p>
                                                                <h6 class="fs-14">{{ getCurrencySymbol() }}{{ $matrixPlan->matrixEnrolled->sum('referral_commissions') }}</h6>
                                                            </div>
                                                            <div class="d-flex justify-content-between align-items-center bg-white p-2">
                                                                <p class="fs-14 fw-normal text--light">{{ __('admin.user.content.level') }}</p>
                                                                <h6 class="fs-14">{{ getCurrencySymbol() }}{{ $matrixPlan->matrixEnrolled->sum('level_commissions') }}</h6>
                                                            </div>
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
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">{{ __('admin.report.statistics.matrix.one') }}</h4>
                        <a href="{{ route('admin.matrix.enrol') }}" class="text--muted text-decoration-underline">{{ __('admin.button.view') }}</a>
                    </div>
                    <div class="card-body">
                        <div class="swiper trade-card-slider">
                            <div class="swiper-wrapper">
                                @forelse($latestMatrixLogs as $latestMatrixLog)
                                    <div class="swiper-slide">
                                        <div class="custom--border bg--icon">
                                            <div class="icon">
                                                <i class="las la-plane text--primary"></i>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center py-2 border--bottom-dash">
                                                    <h6 class="fs-13 fw-bold text--dark">{{ __('admin.table.created_at') }}</h6>
                                                    <p class="mb-0 fs-13 text--light">{{ showDateTime($latestMatrixLog->created_at) }}</p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center py-2 border--bottom-dash">
                                                    <h6 class="fs-13 fw-bold text--dark">{{ __('admin.table.user') }}</h6>
                                                    <p class="mb-0 fs-13 text--light">{{ $latestMatrixLog->user->email }}</p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center py-2 border--bottom-dash">
                                                    <h6 class="fs-13 fw-bold text--dark">{{ __('admin.table.plan') }}</h6>
                                                    <p class="mb-0 fs-13 text--light">{{ $latestMatrixLog->name }}</p>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center py-2 border--bottom-dash">
                                                    <h6 class="fs-13 fw-bold text--dark">{{ __('admin.table.amount') }}</h6>
                                                    <p class="mb-0 fs-13 text--light">{{ getCurrencySymbol() }}{{ shortAmount($latestMatrixLog->price) }}</p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center py-2 border--bottom-dash">
                                                    <h6 class="fs-13 fw-bold text--dark">{{ __('admin.user.content.referral') }}</h6>
                                                    <p class="mb-0 fs-13 text--light">{{ getCurrencySymbol() }}{{ shortAmount($latestMatrixLog->referral_commissions) }}</p>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center py-2 border--bottom-dash">
                                                    <h6 class="fs-13 fw-bold text--dark">{{ __('admin.user.content.level') }}</h6>
                                                    <p class="mb-0 fs-13 text--light">{{ getCurrencySymbol() }}{{ shortAmount($latestMatrixLog->level_commissions) }}</p>
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
    </div>
</section>
@endsection

@push('script-push')
    <script>
        "use strict";
        $(document).ready(function () {
            const currency = "{{ getCurrencySymbol() }}";
            const invest = @json($invest);
            const months = @json($months);

            const investmentOptions = {
                series: [ {
                    name: 'Enrolled Amount',
                    data: invest
                }],
                chart: {
                    height: 290,
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

            const investmentProfit = new ApexCharts(document.querySelector("#matrixChart"), investmentOptions);
            investmentProfit.render();
        });
    </script>
@endpush

