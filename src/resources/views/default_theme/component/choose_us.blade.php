@php
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::CHOOSE_US, \App\Enums\Frontend\Content::FIXED);
    $enhancementContents = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::CHOOSE_US, \App\Enums\Frontend\Content::ENHANCEMENT, 4);
@endphp

<div class="predict-section bg-color pt-110 pb-110" id="prediction">
    <div class="container">
        <div class="row align-items-center gy-5">
            <div class="col-xl-5 col-md-9">
                <div class="section-title style-two text-start">
                    <h2>{{ getArrayValue($fixedContent?->meta, 'heading') }}</h2>
                    <p>{{ getArrayValue($fixedContent?->meta, 'sub_heading') }}</p>
                </div>
                <div class="bet-vecotr">
                    <img src="{{ displayImage(getArrayValue($fixedContent?->meta, 'vector_image'), "512x450") }}" alt="{{ __('Vector Image') }}">
                </div>
            </div>
            <div class="col-xl-7 ps-lg-5">
                <div class="choose-wrapper">
                    <div class="row g-lg-5 g-4">
                        @foreach($enhancementContents as $key => $enhancementContent)
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="choose-item">
                                    <div class="icon">
                                        @php echo getArrayValue($enhancementContent->meta, 'icon') @endphp
                                    </div>
                                    <div class="content">
                                        <h4>{{ getArrayValue($enhancementContent->meta, 'title') }}</h4>
                                        <p>{{ getArrayValue($enhancementContent->meta, 'details') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
