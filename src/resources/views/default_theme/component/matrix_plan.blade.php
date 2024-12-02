
@if(getArrayValue($setting->investment_setting, getInputName(\App\Enums\InvestmentType::MATRIX->name)) == 1)
    @php
        $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::MATRIX_PLAN, \App\Enums\Frontend\Content::FIXED);
    @endphp
    <div class="pricing-section bg-color pt-110 pb-110">
        <div class="container">
            <div class="row justify-content-center align-items-center g-4 mb-60">
                <div class="col-lg-5">
                    <div class="section-title style-two text-center">
                        <h2>{{ getArrayValue($fixedContent?->meta, 'heading') }}</h2>
                        <p>{{ getArrayValue($fixedContent?->meta, 'sub_heading') }}</p>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                @include('user.partials.matrix.plan')
            </div>
        </div>
    </div>
@endif
