@php
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::TESTIMONIAL, \App\Enums\Frontend\Content::FIXED);
    $enhancementContents = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::TESTIMONIAL, \App\Enums\Frontend\Content::ENHANCEMENT);
@endphp

<div class="testimonial-section pt-110 pb-110">
    <div class="quote">
        <i class="bi bi-quote"></i>
    </div>
    <div class="linear-left"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="section-title text-center mb-60">
                    <h2>{{ getArrayValue($fixedContent?->meta, 'heading') }}</h2>
                    <p>{{ getArrayValue($fixedContent?->meta, 'sub_heading') }}</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center align-items-center gy-5 mb-30">
            <div class="col-xl-3">
                <div class="testimonial-card">
                    <h5>{{ getArrayValue($fixedContent?->meta, 'title') }}</h5>
                    <ul>
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= (int)getArrayValue($fixedContent?->meta, 'avg_rating'))
                                <li><i class="bi bi-star-fill"></i></li>
                            @else
                                <li><i class="bi bi-star"></i></li>
                            @endif
                        @endfor
                    </ul>
                    <p><span>{{ getArrayValue($fixedContent?->meta, 'total_reviews') }}</span></p>
                </div>
            </div>

            <div class="col-xl-9">
                <div class="swiper testimonial-slider">
                    <div class="swiper-wrapper">
                        @foreach($enhancementContents as $key => $enhancementContent)
                            <div class="swiper-slide">
                                <div class="testimonial-item">
                                    <div class="content">
                                        <p>{{ getArrayValue($enhancementContent->meta, 'testimonial') }}</p>
                                        <div class="designation">
                                            <h6>{{ getArrayValue($enhancementContent->meta, 'name') }}</h6>
                                            <span>{{ getArrayValue($enhancementContent->meta, 'designation') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div
                class="slider-arrows arrows-style-1 text-center d-flex flex-row justify-content-center align-items-center gap-3 w-100">
                <div class="testi-prev swiper-arrow" tabindex="0" role="button" aria-label="Previous slide">
                    <i class="bi bi-arrow-left"></i>
                </div>
                <div class="testi-next swiper-arrow" tabindex="0" role="button" aria-label="Next slide">
                    <i class="bi bi-arrow-right"></i>
                </div>
            </div>
        </div>
    </div>
</div>

