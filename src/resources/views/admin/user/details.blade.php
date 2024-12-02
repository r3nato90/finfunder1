@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="row g-4">
            <div class="col-xxl-3 col-xl-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('admin.user.content.user_info') }}</h4>
                    </div>
                    <div class="card-body pt-0">
                        <div class="d-flex flex-column align-items-center border--bottom mb-4 py-4 gap-2">
                            <div class="user--profile--image bg--light p-1">
                               <img src="{{ displayImage($user->image) }}" alt="{{ $user->fullname }}">
                            </div>
                            <div class="text-center">
                                <h5 class="mb-3">{{ $user->fullname }}</h5>
                                <span class="d-inline-block fw-bold text--light mb-2">{{ __('admin.table.joined') }}</span><h6 class="fw-normal">{{ showDateTime($user->created_at) }}</h6>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-lg-12">
                                <div class="d-flex justify-content-between align-items-center flex-grow-1 bg--light p-2 w-100">
                                    <h5 class="fw-bold text--dark fs-14">{{ __('admin.user.content.investment') }}</h5>
                                    <a href="{{ route('admin.user.investment', $user->id) }}" class="text--light fs-18" data-bs-toggle="tooltip" data-bs-placement="top"  data-bs-title="{{ getCurrencySymbol() }}{{ shortAmount($investment->total) }}"><i class="bi bi-info-circle"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="d-flex justify-content-between align-items-center flex-grow-1 bg--light p-2 w-100">
                                    <h5 class="fw-bold text--dark fs-15">{{ __('admin.user.content.trade') }}</h5>
                                    <a href="{{ route('admin.user.trade', $user->id) }}" class="text--light fs-18" data-bs-toggle="tooltip" data-bs-placement="top"  data-bs-title="{{ getCurrencySymbol() }}{{ shortAmount($trade->total) }}"><i class="bi bi-info-circle"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="d-flex gap-2 justify-content-between flex-wrap">
                                <a href="{{ route('admin.user.transaction', $user->id) }}" class="btn btn--primary btn--sm flex-grow-1"><i class="las la-wallet fs-16"></i> {{ __('admin.user.content.transaction') }}</a>
                                <a href="{{ route('admin.user.login', $user->id) }}" target="__blank" class="btn btn--dark text-white btn--sm flex-grow-1"><i class="las la-sign-in-alt fs-16"></i> {{ __('admin.user.content.login') }}</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-lg-4 g-3">
                    <div class="col-xl-12 col-lg-6 col-md-6 col-sm-6">
                        <div class="card card--hover linear-card bg--linear-primary text-center">
                            <div class="card-body p-3">
                                <h6 class="text-white opacity-75 fw-normal fs-15 mb-3">{{ __('admin.user.content.referral_statistics') }}</h6>
                                <a href="{{ route('admin.user.referral.tree', $user->id) }}"><i class="bi bi-box-arrow-up-right text-white fs-24"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-6 col-md-6 col-sm-6">
                        <div class="card card--hover linear-card bg--linear-orange text-center">
                            <div class="card-body p-3">
                                <h6 class="text-white opacity-75 fw-normal fs-15 mb-3">{{ __('admin.user.content.statistics') }}</h6>
                                <a href="{{ route('admin.user.statistic', $user->id) }}"><i class="bi bi-box-arrow-up-right text-white fs-24"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-9 col-xl-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row g-3 dash-cards">
                            <div class="col-xl-9">
                                <div class="card account-cover">
                                    <div class="account-bg">
                                    <svg viewBox="0 0 1414 619" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g filter="url(#filter0_d_61_11749)">
                                        <path d="M300.576 288.218L305.664 281.409L299.595 276.874L294.395 282.383L300.576 288.218ZM417.684 375.723L412.596 382.532L417.46 386.166L422.475 382.744L417.684 375.723ZM678.309 197.872L685.037 192.678L680.139 186.332L673.517 190.851L678.309 197.872ZM744.616 283.776L737.887 288.97L741.376 293.49L746.881 291.969L744.616 283.776ZM889.415 243.75L896.639 239.27L893.284 233.862L887.15 235.557L889.415 243.75ZM966.625 368.25L959.401 372.73L964.479 380.917L971.97 374.859L966.625 368.25ZM1409.45 17.8944C1409.95 13.226 1406.56 9.04113 1401.89 8.54718L1325.82 0.497816C1321.15 0.00386716 1316.97 3.3879 1316.47 8.05626C1315.98 12.7246 1319.36 16.9095 1324.03 17.4034L1391.65 24.5584L1384.5 92.181C1384 96.8493 1387.39 101.034 1392.06 101.528C1396.72 102.022 1400.91 98.6381 1401.4 93.9697L1409.45 17.8944ZM17.1812 600.835L306.757 294.052L294.395 282.383L4.81875 589.165L17.1812 600.835ZM295.488 295.027L412.596 382.532L422.771 368.914L305.664 281.409L295.488 295.027ZM422.475 382.744L683.1 204.893L673.517 190.851L412.892 368.702L422.475 382.744ZM671.58 203.066L737.887 288.97L751.345 278.582L685.037 192.678L671.58 203.066ZM746.881 291.969L891.68 251.943L887.15 235.557L742.351 275.583L746.881 291.969ZM882.191 248.23L959.401 372.73L973.849 363.77L896.639 239.27L882.191 248.23ZM971.97 374.859L1406.34 23.6095L1395.66 10.3905L961.28 361.64L971.97 374.859Z" fill="white"/>
                                        </g>
                                        <defs>
                                            <filter id="filter0_d_61_11749" x="0.818726" y="0.449951" width="1412.68" height="618.385" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                            <feOffset dy="14"/>
                                            <feGaussianBlur stdDeviation="2"/>
                                            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.15 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_61_11749"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_61_11749" result="shape"/>
                                            </filter>
                                        </defs>
                                    </svg>
                                    </div>
                                    <div class="card-body p-lg-4 p-3">
                                        <h4 class ="text-white mb-3 fs-22">{{ __('admin.user.content.activities', ['full_name' => $user->fullname ]) }}</h4>
                                        <div class="d-flex align-items-start justify-content-start flex-wrap gap-xxl-5 gap-3">
                                            <div>
                                                <h6 class="text-white fw-normal mb-1 opacity-75">{{ __('admin.user.content.primary_balance') }}</h6>
                                                <span class="opacity-100 text-white fs-16 fw-bold mb-1">{{ getCurrencySymbol() }}{{ shortAmount($user->wallet?->primary_balance )}}</span>
                                            </div>
                                            <div class="border-light-left ps-md-3">
                                                <h6 class="text-white fw-normal mb-1 opacity-75">{{ __('admin.user.content.investment_balance') }}</h6>
                                                <span class="opacity-100 text-white fs-16 fw-bold mb-1">{{ getCurrencySymbol() }}{{ shortAmount($user->wallet?->investment_balance )}}</span>
                                            </div>
                                            <div class="border-light-left ps-md-3">
                                                <h6 class="text-white fw-normal mb-1 opacity-75">{{ __('admin.user.content.trade_balance') }}</h6>
                                                <span class="opacity-100 text-white fs-16 fw-bold mb-1">{{ getCurrencySymbol() }}{{ shortAmount($user->wallet?->trade_balance )}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                                <div class="bg--light p-3 text-center h-100">
                                    <h5 class="text--light mb-1 fs-12 fw-normal">{{ __('admin.user.content.matrix') }}</h5>
                                    <h4 class="fs-18 mb-3">{{ getCurrencySymbol() }}{{ shortAmount(getArrayValue($statistics, 'level_commission') + getArrayValue($statistics, 'referral_commission')) }}</h4>
                                    <a href="{{ route('admin.user.matrix.enrolled', $user->id) }}" class="btn btn--sm btn--dark">{{ __('admin.button.scheme') }}</a>
                                </div>
                            </div>

                            <div class="col-xxl-3 col-xl-6 col-lg-4 col-md-6 col-sm-6">
                                <div class="bg--warning-light border--warning-top p-3 text-start">
                                    <h5 class="text--warning mb-1 fs-12 fw-normal">{{ __('admin.user.content.deposit') }}</h5>
                                    <h4 class="fs-18">{{ getCurrencySymbol() }}{{ shortAmount(getArrayValue($statistics, 'deposit')) }}</h4>
                                    <a href="{{ route('admin.user.deposit', $user->id) }}" class="fs-18 text-dark d-block text-end"><i class="bi bi-box-arrow-up-right"></i></a>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-xl-6 col-lg-4 col-md-6 col-sm-6">
                                <div class="bg--primary-light border--primary-top p-3 text-start">
                                    <h5 class="text--primary mb-1 fs-12 fw-normal">{{ __('admin.user.content.withdraw') }}</h5>
                                    <h4 class="fs-18">{{ getCurrencySymbol() }}{{ shortAmount(getArrayValue($statistics, 'withdraw')) }}</h4>
                                    <a href="{{ route('admin.user.withdraw', $user->id) }}" class="fs-18 text-dark d-block text-end"><i class="bi bi-box-arrow-up-right"></i></a>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-xl-6 col-lg-4 col-md-6 col-sm-6">
                                <div class="bg--success-light border--success-top p-3 text-start">
                                    <h5 class="text--success mb-1 fs-12 fw-normal">{{ __('admin.user.content.level') }}</h5>
                                    <h4 class="fs-18">{{ getCurrencySymbol() }}{{ shortAmount(getArrayValue($statistics, 'level_commission')) }}</h4>
                                    <a href="{{ route('admin.user.level', $user->id) }}" class="fs-18 text-dark d-block text-end"><i class="bi bi-box-arrow-up-right"></i></a>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-xl-6 col-lg-4 col-md-6 col-sm-6">
                                <div class="bg--danger-light border--danger-top p-3 text-start">
                                    <h5 class="text--danger mb-1 fs-12 fw-normal">{{ __('admin.user.content.referral') }}</h5>
                                    <h4 class="fs-18">{{ getCurrencySymbol() }}{{ shortAmount(getArrayValue($statistics, 'referral_commission')) }}</h4>
                                    <a href="{{ route('admin.user.referral', $user->id) }}" class="fs-18 text-dark d-block text-end"><i class="bi bi-box-arrow-up-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('admin.dashboard.content.statistic.deposit') }}</h4>
                    </div>
                    <div class="card-body">
                        <div id="monthlyChart" class="charts-height"></div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('admin.user.content.profile')}}</h4>
                        <div>
                            <button class="i-btn btn--primary btn--lg" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">{{__("admin.user.content.here")}}</button>
                        </div>
                    </div>

                    <div class="card-body py-0">
                        <div class="collapse" id="collapseExample">
                            <form action="{{route('admin.user.update', $user->id)}}" method="POST" enctype="multipart/form-data" class="py-3">
                                @csrf
                                @method('PUT')

                                <input type="hidden" value="{{ $user->id }}" name="id">
                                <div class="row g-3 mb-4">
                                    <div class="col-lg-6">
                                        <div class="form-item">
                                            <label for="first_name" class="form-label">{{ __('admin.input.first_name')}} <sup class="text--danger">*</sup></label>
                                            <input type="text" name="first_name" id="first_name" class="form-control" value="{{$user->first_name}}" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-item">
                                            <label for="last_name" class="form-label">{{ __('admin.input.last_name')}} <sup class="text--danger">*</sup></label>
                                            <input type="text" name="last_name" id="last_name" class="form-control" value="{{$user->last_name}}" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-item">
                                            <label for="email" class="form-label">{{ __('admin.input.email')}} <sup class="text--danger">*</sup></label>
                                            <input type="text" name="email" id="email" class="form-control" value="{{$user->email}}" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-item">
                                            <label for="phone" class="form-label">{{ __('admin.input.phone')}} <sup class="text--danger">*</sup></label>
                                            <input type="text" name="phone" id="phone" class="form-control" value="{{$user->phone}}" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-item">
                                            <label for="address" class="form-label">{{ __('admin.input.address')}} <sup class="text--danger">*</sup></label>
                                            <input type="text" name="address" id="address" class="form-control" value="{{ getArrayValue($user->meta, 'address.address') }}" placeholder="{{ __('Enter Address')}}" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-item">
                                            <label for="city" class="form-label">{{ __('admin.input.city')}} <sup class="text--danger">*</sup></label>
                                            <input type="text" name="city" id="city" class="form-control" value="{{ getArrayValue($user->meta, 'address.city') }}" placeholder="{{ __('Enter City')}}" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-item">
                                            <label for="state" class="form-label">{{ __('admin.input.state')}} <sup class="text--danger">*</sup></label>
                                            <input type="text" name="state" id="state" class="form-control" value="{{ getArrayValue($user->meta, 'address.state') }}" placeholder="{{ __('Enter State')}}" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-item">
                                            <label for="postcode" class="form-label">{{ __('admin.input.postcode')}} <sup class="text--danger">*</sup></label>
                                            <input type="text" name="postcode" id="postcode" class="form-control" value="{{ getArrayValue($user->meta, 'address.postcode') }}" placeholder="{{ __('Enter Zip')}}" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-item">
                                            <label for="kyc_status" class="form-label">{{ __('admin.input.kyc')}} <sup class="text--danger">*</sup></label>
                                            <select class="form-select" name="kyc_status" id="kyc_status">
                                                @foreach(\App\Enums\Status::values() as $status)
                                                    <option value="{{ $status }}" @if( $status == $user->kyc_status) selected @endif>{{ \App\Enums\Status::getName($status) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-item">
                                            <label for="status" class="form-label">{{ __('admin.input.status')}} <sup class="text--danger">*</sup></label>
                                            <select class="form-select" name="status" id="status">
                                                @foreach(\App\Enums\User\Status::values() as $status)
                                                    <option value="{{ $status }}" @if( $status == $user->status) selected @endif>{{ \App\Enums\User\Status::getName($status) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="i-btn btn--primary btn--lg">{{ __('admin.button.save')}}</button>
                            </form>
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
            const depositMonthAmount = @json($depositMonthAmount);
            const withdrawMonthAmount = @json($withdrawMonthAmount);
            const months = @json($months);
            const currency = "{{ getCurrencySymbol() }}";

            const options = {
                series: [
                    {
                        name: 'Total Deposits Amount',
                        data: depositMonthAmount
                    },
                    {
                        name: 'Total Withdraw Amount',
                        data: withdrawMonthAmount
                    }
                ],
                chart: {
                    height: 405,
                    type: 'bar',
                    toolbar: false
                },
                plotOptions: {
                    bar: {
                        borderRadius: 10,
                        dataLabels: {
                            position: 'bottom',
                        },
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val, opts) {
                        return '';
                    },
                    offsetY: -20,
                    style: {
                        fontSize: '12px',
                        colors: ["#304758"]
                    }
                },
                xaxis: {
                    categories: months,
                    position: 'top',
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    crosshairs: {
                        fill: {
                            type: 'gradient',
                            gradient: {
                                colorFrom: '#D8E3F0',
                                colorTo: '#BED1E6',
                                stops: [0, 100],
                                opacityFrom: 0.4,
                                opacityTo: 0.5,
                            }
                        }
                    },
                    tooltip: {
                        enabled: true,
                    }
                },
                yaxis: {
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false,
                    },
                    labels: {
                        show: false,
                        formatter: function (val) {
                            return currency + val;
                        }
                    }
                },
                title: {
                    floating: true,
                    offsetY: 340,
                    align: 'center',
                    style: {
                        color: '#222',
                        fontWeight: 600
                    }
                }
            };

            const chart = new ApexCharts(document.querySelector("#monthlyChart"), options);
            chart.render();
        });
    </script>
@endpush
