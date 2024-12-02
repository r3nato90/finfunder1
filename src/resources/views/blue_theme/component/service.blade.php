@php
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::SERVICE, \App\Enums\Frontend\Content::FIXED);
    $enhancementContents = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::SERVICE, \App\Enums\Frontend\Content::ENHANCEMENT);
@endphp

<section class="service-section pt-120 pb-120">
    <div class="container-fluid container-wrapper">
        <div class="row gy-5 gx-4 align-items-center">
            <div class="col-lg-6">
                <div class="section-title text-start mb-0">
                    <h2>{{ getArrayValue($fixedContent?->meta, 'heading') }}</h2>
                    <p>{{ getArrayValue($fixedContent?->meta, 'sub_heading') }}</p>
                    <ul class="service-list">
                        @foreach($enhancementContents as $key => $enhancementContent)
                            <li>
                                <span>{{ $loop->iteration }}</span> {{ getArrayValue($enhancementContent->meta, 'title') }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="d-flex justify-content-lg-end justify-content-center">
                    <div class="service-img">
                        <img src="{{ displayImage(getArrayValue($fixedContent?->meta, 'blue_theme_image'), '550x525') }}" alt="{{ __('Service Image') }}" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
