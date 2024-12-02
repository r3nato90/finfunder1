@if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::INVESTMENT->name)) == 1)
@php
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::INVESTMENT_PROFIT, \App\Enums\Frontend\Content::FIXED);
@endphp

<section class="profit-calculator pt-120 pb-120 overflow-hidden">
    <div class="container-fluid container-wrapper">
        <div class="row gy-4 justify-content-center mb-60">
            <div class="col-lg-8">
                <div class="section-title text-center mb-0">
                    <h2>{{ getArrayValue($fixedContent?->meta, 'heading') ?? '' }}</h2>
                    <p>{{ getArrayValue($fixedContent?->meta, 'sub_heading') ?? '' }}</p>
                </div>
            </div>
        </div>

        <div class="row align-items-stretch gy-5">
            <div class="col-lg-5 pe-lg-5">
                <div class="profit-result" data-aos="fade-right">
                    <h4 class="profit-subtitle text-white mb-4">{{ __('Profit Calculation') }}</h4>
                    <ul class="profit-list">
                        <li>
                            <span>{{ __('Plan') }}</span>
                            <span id="plan_name">N/A</span>
                        </li>
                        <li>
                            <span>{{ __('Amount') }}</span>
                            <span id="cal_amount">N/A</span>
                        </li>
                        <li>
                            <span>{{ __('Payment Interval') }}</span>
                            <span id="payment_interval">N/A</span>
                        </li>
                        <li>
                            <span>{{ __('Profit') }}</span>
                            <span id="profit">N/A</span>
                        </li>
                        <li>
                            <span>{{ __('Capital Back') }}</span>
                            <span id="capital_back">N/A</span>
                        </li>
                        <li>
                            <span>{{ __('Total') }}</span>
                            <span id="total_invest">N/A</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="profit-calc-wrapper" data-aos="fade-left">
                    <form class="profit-form">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="form-inner">
                                    <label for="select_plan">{{ __('Select Plan') }}</label>
                                    <select id="select_plan">
                                        @foreach ($investments as $plan)
                                            <option value="{{ $plan->id }}"
                                                    data-name="{{ $plan->name }}"
                                                    data-interest="{{ $plan->interest_rate }}"
                                                    data-interest_return_type="{{ $plan->interest_return_type }}"
                                                    data-recapture_type="{{ $plan->recapture_type }}"
                                                    data-day="{{ @$plan->timeTable->name }}"
                                                    data-duration="{{ $plan->duration }}"
                                            >{{ $plan->name }} - {{ __('Interest') }} {{ shortAmount($plan->interest_rate) }}%</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-inner">
                                    <label for="invest_amount_item">{{ __('Amount') }}</label>
                                    <input type="text" id="invest_amount_item" placeholder="{{ __('Enter Amount') }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="button" id="calculate_profit" class="i-btn btn--lg btn--primary pill">{{ __('Profit Planner') }}
                                    <i class="bi bi-arrow-right-short"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@push('script-push')
    <script>
        "use strict";
        $(document).ready(function() {
            var planName = "";
            var interestRate = 0;
            var day = "";
            var duration = 1;
            var recapture_type = 1;
            var interest_return_type = 2

            function updateMinMax() {
                const selectedOption = $('#select_plan option:selected');
                planName = selectedOption.data('name');
                interestRate = selectedOption.data('interest');
                day = selectedOption.data('day');
                duration = selectedOption.data('duration');
                recapture_type = selectedOption.data('recapture_type');
                interest_return_type = selectedOption.data('interest_return_type');
            }

            function updateTotalReturn(amount) {
                var parsedAmount = parseFloat(amount);
                if (isNaN(parsedAmount)) {
                    $("#invest-total-return").text("");
                    return;
                }

                var currency = "{{ getCurrencySymbol() }}";
                var returnAmount = parsedAmount * interestRate / 100;
                $("#invest-total-return").text("Return "+currency + returnAmount.toFixed(2) + " Every " + day + " for " + duration + " Periods");

                var totalProfit = returnAmount * duration;

                if(recapture_type == 2){
                    var total = totalProfit;
                    var capitalBack = 0;
                }else{
                    var total = totalProfit + parsedAmount;
                    var capitalBack = parsedAmount;
                }


                if(interest_return_type == 2){
                    var investProfit = currency+totalProfit.toFixed(2);
                    var returnType = "";
                }else{
                    var investProfit = "LifeTime";
                    var returnType = " + " + "LifeTime";
                }

                $("#plan_name").text(planName);
                $("#cal_amount").text(currency+parsedAmount.toFixed(2));
                $("#payment_interval").text(duration + " Periods");
                $("#profit").text(investProfit);
                $("#capital_back").text(currency+capitalBack.toFixed(2));
                $("#total_invest").text(currency+total.toFixed(2) + returnType);
            }

            updateMinMax();

            $('#select_plan').change(function() {
                updateMinMax();
            });

            $('#calculate_profit').click(function() {
                var amount = $('#invest_amount_item').val();
                updateTotalReturn(amount);
            });
        });
    </script>
@endpush
@endif
