@if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::INVESTMENT->name)) == 1)
    @php
        $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::PRICING_PLAN, \App\Enums\Frontend\Content::FIXED);
    @endphp

    <div class="pricing-section pt-110 pb-110">
        <div class="container">
            <div class="row justify-content-lg-start justify-content-center align-items-center g-4 mb-60">
                <div class="col-lg-5">
                    <div class="section-title text-lg-start text-center">
                        <h2>{{ getArrayValue($fixedContent?->meta, 'heading') }}</h2>
                        <p> {{ getArrayValue($fixedContent?->meta, 'sub_heading') }} </p>
                    </div>
                </div>
            </div>
            <div>
                @include('user.partials.investment.plan')
            </div>
        </div>
    </div>

    @include('user.partials.investment.plan_modal')
@endif
