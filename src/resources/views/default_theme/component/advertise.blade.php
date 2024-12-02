@php
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::ADVERTISE, \App\Enums\Frontend\Content::FIXED);
    $enhancementContents = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::ADVERTISE, \App\Enums\Frontend\Content::ENHANCEMENT);
@endphp

<div class="advertise-section bg-color pt-110 pb-110">
    <div class="container">
        <div class="row align-items-center justify-content-xl-between justify-content-center gy-5">
            <div class="col-xl-6 pe-xl-5">
                <div class="introduction-wrapper">
                    <div class="section-title style-two text-start">
                        <h2 class="mb-lg-5 mb-4">{{ getArrayValue($fixedContent?->meta, 'heading') }}</h2>
                        <h4>{{ getArrayValue($fixedContent?->meta, 'sub_heading') }}</h4>
                        <ul>
                            @foreach($enhancementContents as $key => $enhancementContent)
                                <li><i class="bi bi-shield-check"></i>{{ getArrayValue($enhancementContent->meta, 'title') }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-9 col-10 offset-xl-1">
                <div class="advertise-slider-wrap">
                    <div class="swiper advertise-slider">
                        <div class="swiper-wrapper">
                            @foreach($enhancementContents as $key => $enhancementContent)
                                <div class="swiper-slide">
                                    <img src="{{ displayImage(getArrayValue($enhancementContent->meta, 'advertise_image'), "800x600") }}" alt="{{ __('image') }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
