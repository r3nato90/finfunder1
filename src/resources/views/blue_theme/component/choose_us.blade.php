@php
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::CHOOSE_US, \App\Enums\Frontend\Content::FIXED);
    $enhancementContents = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::CHOOSE_US, \App\Enums\Frontend\Content::ENHANCEMENT, 4);
@endphp
<section class="predict-section analytics pt-120 pb-120">
    <div class="banner-blur"></div>
    <div class="container-fluid container-wrapper">
        <div class="row gx-xl-5 gy-5">
            <div class="col-xl-5">
                <div class="row g-4 gy-5 align-items-center">
                    <div class="col-xl-12 col-lg-8">
                        <div class="section-title title-secondary text-start mb-0">
                            <h2>{{ getArrayValue($fixedContent?->meta, 'heading') }}</h2>
                            <p>{{ getArrayValue($fixedContent?->meta, 'sub_heading') }}</p>
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-4">
                        <div class="analytic-img">
                            <img src="{{ displayImage(getArrayValue($fixedContent?->meta, 'vector_image'), "512x450") }}" alt="bitcoin" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-7">
                <div class="row g-4 analytic-card-wrapper">
                    @foreach($enhancementContents as $key => $enhancementContent)
                        <div class="col-md-6 analytic-card-item">
                            <div class="analytic-card" data-aos="zoom-in-right">
                                <span class="analytic-icon">
                                   @php echo getArrayValue($enhancementContent->meta, 'icon') @endphp
                                </span>
                                <div class="analytic-content">
                                    <h5>{{ getArrayValue($enhancementContent->meta, 'title') }}</h5>
                                    <p>{{ getArrayValue($enhancementContent->meta, 'details') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
