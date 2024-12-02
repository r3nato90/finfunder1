@php
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::MATRIX_PLAN, \App\Enums\Frontend\Content::FIXED);
@endphp
@foreach($matrix as $key => $plan)
    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6">
        <div class="pricing-item card-style">
            @if($plan->is_recommend)
                <div class="recommend">
                    <span>{{ __('Recommend') }}</span>
                </div>
            @endif
            <div class="icon">
                <img src="{{ displayImage(getArrayValue($fixedContent?->meta, 'award_image')) }}" alt="{{ __('Award Image') }}" border="0">
            </div>
            <div class="header">
                <div class="price">{{getCurrencySymbol()}}{{ shortAmount($plan->amount) }}</div>
                <h4 class="title">{{ $plan->name }}</h4>
                <div class="price-info">
                    <h6 class="mb-1">{{ __('Straightforward Referral Reward') }}: {{getCurrencySymbol()}}{{ shortAmount($plan->referral_reward) }}</h6>
                    <h6 class="mb-2">{{ __('Aggregate Level Commission') }}: {{ getCurrencySymbol() }}{{ \App\Services\Investment\MatrixService::calculateAggregateCommission((int)$plan->id) }}</h6>
                    <p class="mb-0">{{ __('Get back') }} <span>{{ shortAmount((\App\Services\Investment\MatrixService::calculateAggregateCommission((int)$plan->id) / $plan->amount) * 100) }}%</span> {{ __('of what you invested') }}</p>
                </div>
            </div>
            <div class="body">
                <ul class="pricing-list">
                    @foreach (\App\Services\Investment\MatrixService::calculateTotalLevel($plan->id) as $value)
                        @php
                            $matrix = pow(\App\Services\Investment\MatrixService::getMatrixWidth(), $loop->iteration)
                        @endphp
                        <li>
                            {{ __('Level') }}-{{ $loop->iteration }} <span class="px-2">>></span>
                            {{getCurrencySymbol()}}{{shortAmount($value->amount)}}x{{$matrix}} =
                            {{getCurrencySymbol()}}{{ shortAmount($value->amount * $matrix) }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="footer">
                <button class="i-btn btn--primary btn--lg capsuled w-100 enroll-matrix-process"
                    data-bs-toggle="modal"
                    data-bs-target="#enrollMatrixModal"
                    data-uid="{{ $plan->uid }}"
                    data-name="{{ $plan->name }}"
                >{{ __('Start Investing Now') }}</button>
            </div>
        </div>
    </div>
@endforeach
