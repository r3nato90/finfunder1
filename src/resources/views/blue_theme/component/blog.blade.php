@php
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::BLOG, \App\Enums\Frontend\Content::FIXED);
    $enhancementContents = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::BLOG, \App\Enums\Frontend\Content::ENHANCEMENT, 4);
@endphp

<section class="blog-section pt-120">
    <div class="container-fluid container-wrapper">
        <div class="section-title title-fluid">
            <div class="title-left">
                <h2 class="mb-0">{{ getArrayValue($fixedContent?->meta, 'heading') }}</h2>
            </div>

            <div class="title-right">
                <p>{{ getArrayValue($fixedContent?->meta, 'sub_heading') }}</p>
                <div class="d-flex align-items-center justify-content-between">
                    <a href=" {{ getArrayValue($fixedContent?->meta, 'blue_theme_btn_url') }}" class="i-btn btn--primary btn--lg pill w-fit-content">
                        {{ getArrayValue($fixedContent?->meta, 'blue_theme_btn_name') }}
                    </a>

                    <div class="d-flex align-items-center gap-3">
                        <button class="icon-btn btn-lg primary-soft hover circle button-prev">
                            <i class="bi bi-arrow-left"></i>
                        </button>

                        <button class="icon-btn btn-lg primary-soft hover circle button-next">
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="swiper blog-slider">
            <div class="swiper-wrapper">
                @foreach($enhancementContents as $key => $enhancementContent)
                    <div class="swiper-slide">
                        <a href="{{ route('blog.detail', $enhancementContent->id) }}" class="blog-card">
                            <div class="row gy-2 align-items-center">
                                <div class="col-12">
                                    <picture>
                                        <img src="{{ displayImage(getArrayValue($enhancementContent->meta, 'thumb_image'), '800x500') }}" alt="" />
                                    </picture>
                                </div>

                                <div class="col-12">
                                    <div class="blog-caption">
                                        <span class="fs-14 text-primary fw-medium">{{ showDateTime($enhancementContent->created_at, 'd') }} , {{ showDateTime($enhancementContent->created_at, 'M Y') }}</span>
                                        <h4>{{ getArrayValue($enhancementContent->meta, 'title') }}</h4>
                                        <p>{{ strip_tags(getArrayValue($enhancementContent?->meta, 'description')) }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

