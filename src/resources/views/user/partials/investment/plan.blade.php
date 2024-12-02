<div class="row align-items-center gy-4">
    @foreach($investments as $key => $investment)
        <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6">
            <div class="pricing-item style-two">
                @if($investment->is_recommend)
                    <div class="recommend">
                        <span>{{ __('Recommend') }}</span>
                    </div>
                @endif

                <div class="header">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="title">{{ $investment->name }}</h4>
                        @if($investment->interest_return_type == \App\Enums\Investment\ReturnType::REPEAT->value)
                            <div class="price mt-0">{{ (int)$investment->duration }} {{ $investment->timeTable->name ?? '' }}</div>
                        @else
                            <div class="price mt-0">{{ __('Lifetime') }}</div>
                        @endif
                    </div>

                    <div class="d-flex justify-content-between flex-wrap align-items-center gap-2">
                        <p class="text-start fs-16 mb-0">{{ __('Interest Rate') }}: <span class="text-white"> {{ shortAmount($investment->interest_rate) }}{{ \App\Enums\Investment\InterestType::getSymbol($investment->interest_type) }} </span></p>
                        <button class="fs-15 terms-policy bg-transparent" type="button"
                            data-bs-toggle="modal"
                            data-bs-target="#termsModal"
                            data-terms_policy="@php echo $investment->terms_policy @endphp"
                        >
                            <i class="bi bi-info-circle me-2 color--primary"></i>{{ __('Terms and Policies') }}
                        </button>
                    </div>
                </div>
                <div class="body">
                    <h6 class="mb-4">
                        <span class="text--light">
                            {{ __('Investment amount limit') }}
                        </span> : @if($investment->type == \App\Enums\Investment\InvestmentRage::RANGE->value)
                            {{ getCurrencySymbol() }}{{shortAmount($investment->minimum)}}
                            - {{ getCurrencySymbol() }}{{shortAmount($investment->maximum)}}
                        @else
                            {{ getCurrencySymbol() }}{{shortAmount($investment->amount)}}
                        @endif
                    </h6>
                    <ul class="pricing-list">
                        @if(!empty($investment->meta))
                            @foreach($investment->meta as $value)
                                <li>
                                    <span>{{ $value }}</span>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                    <h6 class="mb-4">
                        <span class="text-end text--light">{{ __('Total Return') }}</span> :
                        @if ($investment->interest_return_type == \App\Enums\Investment\ReturnType::REPEAT->value)
                            {{ totalInvestmentInterest($investment) }}
                        @else
                            @lang('Unlimited')
                        @endif

                        @if($investment->recapture_type == \App\Enums\Investment\Recapture::HOLD->value)
                            <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" title="Hold capital & reinvest">
                                  <i class="bi bi-info-circle me-2 color--primary"></i>
                            </span>
                        @endif
                    </h6>
                </div>
                <div class="footer">
                    <button
                        class="i-btn btn--dark btn--lg capsuled w-100 invest-process"
                        data-bs-toggle="modal"
                        data-bs-target="#investModal"
                        data-name="{{ $investment->name }}"
                        data-uid="{{ $investment->uid }}"
                    >{{ __('Invest Now') }}</button>
                </div>
            </div>
        </div>
    @endforeach
</div>

