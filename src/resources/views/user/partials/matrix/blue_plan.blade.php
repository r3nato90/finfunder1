@php
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::MATRIX_PLAN, \App\Enums\Frontend\Content::FIXED);
@endphp
@foreach($matrix as $key => $plan)
    <div class="col-xl-6">
        <div class="community-card   @if($plan->is_recommend) recommend @endif">
            @if($plan->is_recommend)
                <span class="recommend-tag">{{ __('Recommend') }}</span>
            @endif
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="community-card-left">
                        <span>{{ $plan->name }}</span>
                        <h6>{{getCurrencySymbol()}}{{ shortAmount($plan->amount) }}</h6>
                        <div class="referral-note">
                            <p>{{ __('Straightforward Referral Reward') }}: {{getCurrencySymbol()}}{{ shortAmount($plan->referral_reward) }}</p>
                            <p>{{ __('Aggregate Level Commission') }}: {{ getCurrencySymbol() }}{{ \App\Services\Investment\MatrixService::calculateAggregateCommission((int)$plan->id) }}</p>
                            <span>{{ __('Get back') }} <span>{{ shortAmount((\App\Services\Investment\MatrixService::calculateAggregateCommission((int)$plan->id) / $plan->amount) * 100) }}%</span> {{ __('of what you invested') }}</span>
                        </div>

                        <button class="i-btn btn--primary btn--lg pill enroll-matrix-process"
                                data-bs-toggle="modal"
                                data-bs-target="#enrollMatrixModal"
                                data-uid="{{ $plan->uid }}"
                                data-name="{{ $plan->name }}"
                        >{{ __('Start Investing Now') }}</button>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="community-card-right">
                        <ul class="community-feature">
                            @foreach (\App\Services\Investment\MatrixService::calculateTotalLevel($plan->id) as $value)
                                @php
                                    $matrix = pow(\App\Services\Investment\MatrixService::getMatrixWidth(), $loop->iteration)
                                @endphp
                                <li>
                                    <i class="bi bi-check2-circle"></i> {{ __('Level') }}-{{ $loop->iteration }} >>
                                    {{getCurrencySymbol()}}{{shortAmount($value->amount)}}x{{$matrix}} =
                                    {{getCurrencySymbol()}}{{ shortAmount($value->amount * $matrix) }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
