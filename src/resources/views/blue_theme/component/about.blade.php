@php
   $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::ABOUT, \App\Enums\Frontend\Content::FIXED);
   $enhancementContents = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::ABOUT, \App\Enums\Frontend\Content::ENHANCEMENT);
@endphp

<section class="about-us pt-120 pb-120">
    <div class="container-fluid container-wrapper">
        <div class="about-wrapper" data-aos="zoom-in">
            <div class="row gx-xl-5 gy-5 align-items-start">
                <div class="col-xl-6">
                    <div class="about-content">
                        <div class="section-title title-secondary text-start mb-0">
                            <h2>{{ getArrayValue($fixedContent?->meta, 'heading') }}</h2>
                            <p>{{ getArrayValue($fixedContent?->meta, 'sub_heading') }}</p>
                        </div>
                    </div>
                    <div class="about-countdown">
                        <div class="row g-sm-5 g-3 justify-content-center">
                            <div class="col-sm-4 col-6">
                                <div class="about-card bg--info text-white">
                                    <h5 class="text-white">{{ getArrayValue($fixedContent?->meta, 'first_item_count') }}</h5>
                                    <span>{{ getArrayValue($fixedContent?->meta, 'first_item_title') }}</span>
                                </div>
                            </div>

                            <div class="col-sm-4 col-6">
                                <div class="about-card bg--primary">
                                    <h5>{{ getArrayValue($fixedContent?->meta, 'second_item_count') }}</h5>
                                    <span>{{ getArrayValue($fixedContent?->meta, 'second_item_title') }}</span>
                                </div>
                            </div>

                            <div class="col-sm-4 col-6">
                                <div class="about-card bg--warning">
                                    <h5>{{ getArrayValue($fixedContent?->meta, 'third_item_count') }}</h5>
                                    <span>{{ getArrayValue($fixedContent?->meta, 'third_item_title') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <ul>
                        @foreach($enhancementContents as $key => $enhancementContent)
                        <li>
                            <span> @php echo getArrayValue($enhancementContent->meta, 'icon') @endphp</span>
                            {{ getArrayValue($enhancementContent->meta, 'title') }}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
