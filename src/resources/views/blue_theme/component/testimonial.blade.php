@php
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::TESTIMONIAL, \App\Enums\Frontend\Content::FIXED);
    $enhancementContents = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::TESTIMONIAL, \App\Enums\Frontend\Content::ENHANCEMENT);
@endphp

<section class="testimonial pb-120 pt-120">
    <div class="container-fluid container-wrapper">
        <div class="row gy-4 justify-content-center mb-60">
            <div class="col-lg-8">
                <div class="section-title text-center mb-0">
                    <h2>{{ getArrayValue($fixedContent?->meta, 'heading') }}</h2>
                    <p>{{ getArrayValue($fixedContent?->meta, 'sub_heading') }}</p>
                </div>
            </div>
        </div>

        <div class="row mb-30">
            <div class="d-flex w-100 align-items-center flex-row justify-content-between flex-wrap gap-lg-5 gap-4">
                <div class="review-badge">
                    <ul>
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= (int)getArrayValue($fixedContent?->meta, 'avg_rating'))
                                <li><i class="bi bi-star-fill"></i></li>
                            @else
                                <li><i class="bi bi-star"></i></li>
                            @endif
                        @endfor
                    </ul>
                    <span>{{ getArrayValue($fixedContent?->meta, 'total_reviews') }} {{ getArrayValue($fixedContent?->meta, 'title') }}</span>
                </div>

                <div class="d-flex align-items-center justify-content-end gap-3">
                    <button class="icon-btn btn-xl primary-soft hover circle review-prev">
                        <i class="bi bi-arrow-left"></i>
                    </button>

                    <button class="icon-btn btn-xl primary-soft hover circle review-next">
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="swiper review-slider">
            <div class="swiper-wrapper">
                @foreach($enhancementContents as $key => $enhancementContent)
                    <div class="swiper-slide">
                        <div class="review-card">
                            <span class="quote-icon"><i class="bi bi-quote"></i></span>
                            <p>{{ getArrayValue($enhancementContent->meta, 'testimonial') }}</p>
                            <div class="reviewer">
                                <h6>{{ getArrayValue($enhancementContent->meta, 'name') }}</h6>
                                <span>{{ getArrayValue($enhancementContent->meta, 'designation') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
