@extends('layouts.user')
@section('content')
    <div class="main-content" data-simplebar>
        <div class="row">
            <div class="col-lg-12">
                <div class="row g-4">
                    <div class="col-lg-5">
                        <div class="i-card-sm mb-4">
                            <h5 class="title">{{ __($setTitle) }}</h5>
                            <div class="d-flex align-items-center gap-3 mb-4">
                                @foreach(['Trade Balance', 'Practice Balance'] as $balanceType)
                                    <div class="i-card-sm bg--dark shadow-none flex-grow-1 py-3 px-4 rounded-3">
                                        <span class="inline-block lh-1 text--light">{{ __($balanceType) }}</span>
                                        <h5 class="mt-2">{{ getCurrencySymbol() }}{{ shortAmount(Auth::user()->wallet->{$balanceType === 'Trade Balance' ? 'trade_balance' : 'practice_balance'}) }}</h5>
                                    </div>
                                @endforeach
                            </div>

                            <ul class="d-flex flex-column gap-2">
                                @foreach (['total', 'today', 'wining', 'loss', 'draw', 'high', 'low'] as $key)
                                    <li class="p-3 d-flex bg--dark">
                                        <div class="flex-grow-1 d-flex align-items-center gap-3">
                                            <h5 class="text--light fs-14">{{ __("admin.report.statistics.trade.one.{$key}") }}</h5>
                                        </div>
                                        <div class="flex-shrink-0 text-end">
                                            <h5 class="text-white fw-bold fs-14">{{ getCurrencySymbol() }}{{ shortAmount($trade->$key) }}</h5>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="i-card-sm">
                            <div id="totalTrade"></div>
                        </div>
                    </div>
                </div>

                <div class="i-card-sm mb-4">
                    <div class="card-header">
                        <h4 class="title">{{ __($setTitle) }}</h4>
                    </div>
                    <div class="filter-area">
                        <form action="{{ route('user.trade.tradelog') }}">
                            <div class="row row-cols-lg-4 row-cols-md-4 row-cols-sm-2 row-cols-1 g-3">
                                <div class="col">
                                    <select class="select2-js" name="outcome">
                                        @foreach (App\Enums\Trade\TradeOutcome::cases() as $status)
                                            <option value="{{ $status->value }}" @if($status->value == request()->outcome) selected @endif>{{ $status->name  }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="select2-js" name="volume">
                                        @foreach (App\Enums\Trade\TradeVolume::cases() as $status)
                                            <option value="{{ $status->value }}" @if($status->value == request()->volume) selected @endif>{{ $status->name  }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <input type="text" id="date" class="form-control datepicker-here" name="date"
                                       value="{{ request()->get('date') }}" data-range="true" data-multiple-dates-separator=" - "
                                       data-language="en" data-position="bottom right" autocomplete="off"
                                       placeholder="{{ __('Date') }}">
                                </div>
                                <div class="col">
                                    <button type="submit" class="i-btn btn--lg btn--primary w-100"><i class="bi bi-search me-3"></i>{{ __('Search') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="table-container">
                        @include('user.partials.trade.trade-history', ['tradeLogs' => $tradeLogs])
                    </div>
                    <div class="mt-4">{{ $tradeLogs->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-push')
    <script>
        "use strict";

        $(document).ready(function () {
            const amount = @json($amount);
            const days = @json($days);
            const currency = "{{ getCurrencySymbol() }}";
            const content = "{{ __('admin.report.statistics.trade.five') }}";
            const tradeContent = "{{ __('Trade Amount') }}";

            const options = {
                series: [{
                    name: tradeContent,
                    data: amount
                }],
                chart: {
                    type: 'bar',
                    height: 535,
                    toolbar: false,
                    foreColor: '#ffffff'
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
                    labels: {
                        style: {
                            colors: '#ffffff' 
                        }
                    }
                },
                yaxis: {
                    title: {
                        text: content,
                        style: {
                            color: '#ffffff' 
                        }
                    },
                    labels: {
                        style: {
                            colors: '#ffffff'
                        }
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return currency + val;
                        },
                        style: {
                            color: '#ffffff'
                        }
                    }
                }
            };
            const chart = new ApexCharts(document.querySelector("#totalTrade"), options);
            chart.render();
        });

    </script>
@endpush

