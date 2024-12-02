@php
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::SERVICE, \App\Enums\Frontend\Content::FIXED);
    $enhancementContents = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::SERVICE, \App\Enums\Frontend\Content::ENHANCEMENT);
@endphp

<div class="service-section pt-110 pb-110">
    <div class="linear-right"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-9">
                <div class="section-title text-center mb-60">
                    <h2>{{ getArrayValue($fixedContent?->meta, 'heading') }}</h2>
                    <p>{{ getArrayValue($fixedContent?->meta, 'sub_heading') }}</p>
                </div>
            </div>
        </div>
        <div class="row align-items-center service-tab-wrapper">
            <div class="col-lg-6">
                @foreach($enhancementContents as $key => $enhancementContent)
                    <article class="tab-pane {{ $loop->first ? 'show active' : '' }}" id="category_tab{{ $loop->iteration }}">
                        <img src="{{ displayImage(getArrayValue($enhancementContent->meta, 'service_image'), "636x477") }}" alt="{{ __('Service image-'. $loop->iteration ) }}">
                    </article>
                @endforeach
            </div>
            <div class="col-lg-6 ps-lg-5">
                <nav id="myTab" class="nav nav-pills flex-column service-title-wrap">
                    @foreach($enhancementContents as $key => $enhancementContent)
                        <a href="#category_tab{{ $loop->iteration }}" data-bs-toggle="pill" data-cursor="View" class="{{ $loop->first ? 'active' : '' }} nav-link"><span>{{ getArrayValue($enhancementContent->meta, 'title') }}</span>
                            <i class="bi bi-arrow-right-short"></i>
                        </a>
                    @endforeach
                </nav>
            </div>
        </div>
    </div>
</div>
