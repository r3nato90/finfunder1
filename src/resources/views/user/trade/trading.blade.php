@extends('layouts.auth')
@section('content')
    <main>
        <div class="trading-section pt-5 pb-110">
            <div class="container i-container">
                <div class="row g-4">
                    <div class="col-xl-9">
                        <div class="market-graph">
                            <div class="mb-5">
                                @include('user.partials.trade.trading-view')
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        @include('user.partials.trade.binary-trade')
                    </div>
                    <div class="col-xl-12">
                    @include('user.partials.trade.trade-log')
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('script-push')
    <script>
        'use strict';
        $(document).ready(function() {
            $("#amount").on('keyup', function() {
                const inputAmount = parseFloat($(this).val());
                const commissionPercentage = {{ getArrayValue($setting->commissions_charge, 'binary_trade_commissions', 0) }};

                if (isNaN(inputAmount)) {
                    $("#profit_amount").text('+' + 0.00);
                    return;
                }

                const profit = (commissionPercentage / 100) * inputAmount;
                const withProfitAmount = parseFloat(inputAmount) + parseFloat(profit);

                $("#profit_amount").text('+' + withProfitAmount.toFixed(2));
            });
        });
    </script>
@endpush






