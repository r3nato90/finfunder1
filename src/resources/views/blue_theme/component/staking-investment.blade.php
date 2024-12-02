@if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::STAKING_INVESTMENT->name)) == 1)
    @php
        $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::STAKING_INVESTMENT, \App\Enums\Frontend\Content::FIXED);
    @endphp
    <section class="investment-section bg--dark pt-120 pb-120">
        <div class="banner-blur"></div>
        <div class="container-fluid container-wrapper">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title title-secondary text-center b-0">
                        <h2>{{ getArrayValue($fixedContent?->meta, 'heading') ?? '' }}</h2>
                        <p>{{ getArrayValue($fixedContent?->meta, 'sub_heading') ?? '' }}</p>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                @foreach($stakingInvestments as $stakingInvestment)
                <div class="col-xl-6">
                    <div class="invest-card">
                        <div class="row align-items-center g-4">
                            <div class="col-md-3">
                                <div class="interest">
                                    <h4>{{ shortAmount($stakingInvestment->interest_rate) }}%</h4>
                                    <span>{{ __('Interest') }}</span>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="row g-3 align-items-center">
                                    <div class="col-sm-4">
                                        <div class="info-item">
                                            <span>{{ __('Duration') }}</span>
                                            <span>{{ $stakingInvestment->duration }} {{ __('Days') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="info-item">
                                            <span>{{ __('Capital Limit') }}</span>
                                            <span>{{ getCurrencySymbol() }}{{ shortAmount($stakingInvestment->minimum_amount) }} - {{ getCurrencySymbol() }}{{ shortAmount($stakingInvestment->maximum_amount) }}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="text-sm-end text-center">
                                            <button class="i-btn btn--primary btn--md pill invest-process staking-investment-process" data-bs-toggle="modal" data-bs-target="#staking-investment"
                                                    data-min="{{ getCurrencySymbol() }}{{ shortAmount($stakingInvestment->minimum_amount) }}"
                                                    data-max="{{ getCurrencySymbol() }}{{ shortAmount($stakingInvestment->maximum_amount) }}"
                                                    data-interest="{{ $stakingInvestment->interest_rate }}"
                                                    data-plan_id="{{ $stakingInvestment->id }}"
                                            >{{ __('Invest Now') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <div class="modal fade" id="staking-investment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h5 class="modal-title text-white">{{ __('Staking Invest Now') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="{{ route('user.staking-investment.store') }}">
                    @csrf
                    <input type="hidden" name="plan_id" id="plan_id" value="">

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="staking-amount" class="col-form-label">{{ __('Amount') }} (<span id="min-amount"></span> - <span id="max-amount"></span>)</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="staking-amount" name="amount" placeholder="{{ __('Enter Amount') }}" aria-label="Amount" aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2">{{ getCurrencyName() }}</span>
                            </div>
                            <small id="staking-total-return"></small>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="i-btn btn--light btn--md" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="i-btn btn--primary btn--md">{{ __('Submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('script-push')
        <script>
            "use strict";
            $(".staking-investment-process").click(function() {
                var minAmount = $(this).data('min');
                var maxAmount = $(this).data('max');
                var interestRate = $(this).data('interest');
                var planId = $(this).data('plan_id');

                $('#min-amount').text(minAmount);
                $('#max-amount').text(maxAmount);
                $('#plan_id').val(planId);


                function updateTotalReturn(amount) {
                    var parsedAmount = parseFloat(amount.replace(/[^0-9.-]+/g,""));
                    if (isNaN(parsedAmount)) {
                        $("#staking-total-return").text("");
                        return;
                    }
                    var returnAmount = parsedAmount * interestRate / 100 + parsedAmount;
                    $("#staking-total-return").text("Total Return: {{ getCurrencySymbol() }}" + returnAmount.toFixed(2) + " after the complete investment period");
                }

                $('#staking-amount').off('keyup').on('keyup', function() {
                    var amount = $(this).val();
                    updateTotalReturn(amount);
                });
            });
        </script>
    @endpush
@endif
