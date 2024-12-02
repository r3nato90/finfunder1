@php
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::BLOG, \App\Enums\Frontend\Content::FIXED);
    $enhancementContents = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::BLOG, \App\Enums\Frontend\Content::ENHANCEMENT, 4);
@endphp

<div class="blog-section position-relative pt-110 pb-110">
    <div class="linear-right"></div>
    <div class="container">
        <div class="row justify-content-center g-4">
            <div class="col-lg-5">
                <div class="section-title text-center mb-60">
                    <h2>{{ getArrayValue($fixedContent?->meta, 'heading') }}</h2>
                    <p>{{ getArrayValue($fixedContent?->meta, 'sub_heading') }}</p>
                </div>
            </div>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="row g-3">
                <div class="col-12">
                    <div class="swiper blog-slider">
                        <div class="swiper-wrapper">
                            @foreach($enhancementContents as $key => $enhancementContent)
                                <div class="swiper-slide">
                                    <div class="blog-item-two">
                                        <div class="image">
                                            <img src="{{ displayImage(getArrayValue($enhancementContent->meta, 'thumb_image'), '800x500') }}" alt="{{ __('thumb Image') }}">
                                            <div class="date">
                                                <h5>{{ showDateTime($enhancementContent->created_at, 'd') }}</h5>
                                                <p>{{ showDateTime($enhancementContent->created_at, 'M') }}</p>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <h4 class="card--title">
                                                <a href="{{ route('blog.detail', $enhancementContent->id) }}" data-cursor="View Details">{{ getArrayValue($enhancementContent->meta, 'title') }}</a>
                                            </h4>
                                            <a href="{{ route('blog.detail', $enhancementContent->id) }}" class="i-btn read-more-btn">{{ __('Read More') }} <i class="bi bi-arrow-up-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="card-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

