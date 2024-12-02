@foreach($investments as $key => $investment)
    <div class="col-xl-4 col-md-6">
        <div class="plan-card @if($investment->is_recommend) recommend @endif">
            <div class="plan-card-header">
                <div class="plan-title">
                    <div class="icon-btn btn-md primary-solid circle">
                        <i class="bi bi-lightning-charge-fill"></i>
                    </div>
                    <span>{{ $investment->name }} </span>
                </div>
                @if($investment->interest_return_type == \App\Enums\Investment\ReturnType::REPEAT->value)
                    <h6>{{ (int)$investment->duration }} {{ $investment->timeTable->name ?? '' }}</h6>
                @else
                    <h6>{{ __('Lifetime') }}</h6>
                @endif
                <p>{{ __('Interest Rate') }}: {{ shortAmount($investment->interest_rate) }}{{ \App\Enums\Investment\InterestType::getSymbol($investment->interest_type) }}</p>
            </div>

            @if($investment->is_recommend)
                <span class="recommend-tag"> {{ __('Recommend') }} </span>
            @endif

            <ul class="pricing-list">
                <li>
                    <i class="bi bi-check2-circle"></i>Investment amount limit : <span> @if($investment->type == \App\Enums\Investment\InvestmentRage::RANGE->value)
                            {{ getCurrencySymbol() }}{{shortAmount($investment->minimum)}}
                            - {{ getCurrencySymbol() }}{{shortAmount($investment->maximum)}}
                        @else
                            {{ getCurrencySymbol() }}{{shortAmount($investment->amount)}}
                        @endif</span>
                </li>
                @if(!empty($investment->meta))
                    @foreach($investment->meta as $value)
                        <li>
                            <i class="bi bi-check2-circle"></i>{{ $value }}
                        </li>
                    @endforeach
                @endif
                <li>
                    <i class="bi bi-check2-circle"></i>Total Return :
                    <span>@if ($investment->interest_return_type == \App\Enums\Investment\ReturnType::REPEAT->value)
                            {{ totalInvestmentInterest($investment) }}
                        @else
                            @lang('Unlimited')
                        @endif

                        @if($investment->recapture_type == \App\Enums\Investment\Recapture::HOLD->value)
                            <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" title="Hold capital & reinvest">
                                  <i class="bi bi-info-circle me-2 color--primary"></i>
                            </span>
                        @endif
                    </span>
                </li>
            </ul>

            <p class="fs-14 mt-4 text-center terms-policy" role="button" data-bs-toggle="modal" data-bs-target="#termsModal"  data-terms_policy="@php echo $investment->terms_policy @endphp">
                <i class="bi bi-info-circle-fill text-info"></i>{{ __('Terms and Policies') }}
            </p>

            <div class="mt-10">
                <button
                    class="i-btn btn--primary btn--xl pill w-100 invest-process"
                    data-bs-toggle="modal"
                    data-bs-target="#investModal"
                    data-name="{{ $investment->name }}"
                    data-uid="{{ $investment->uid }}"
                >{{ __('Invest Now') }}
                </button>
            </div>
        </div>
    </div>
@endforeach
