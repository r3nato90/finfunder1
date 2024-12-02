@if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::INVESTMENT->name)) == 1)
    @php
        $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::PRICING_PLAN, \App\Enums\Frontend\Content::FIXED);
    @endphp

    <section class="plan pb-120 pt-120">
        <div class="container-fluid container-wrapper">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-10">
                    <div class="section-title text-center">
                        <h2>{{ getArrayValue($fixedContent?->meta, 'heading') }}</h2>
                        <p> {{ getArrayValue($fixedContent?->meta, 'sub_heading') }} </p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center g-4">
                @include('user.partials.investment.blue_plan')
            </div>
        </div>
    </section>
    @include('user.partials.investment.plan_modal')
@endif
