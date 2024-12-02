@php
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::FEATURE, \App\Enums\Frontend\Content::FIXED);
    $enhancementContents = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::FEATURE, \App\Enums\Frontend\Content::ENHANCEMENT);
@endphp
<section class="market-analytic pt-120 pb-120">
    <div class="container-fluid container-wrapper">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-10">
                <div class="section-title text-center">
                    <h2>{{ __(getArrayValue($fixedContent?->meta, 'heading')) }}</h2>
                    <p>{{ __(getArrayValue($fixedContent?->meta, 'sub_heading')) }}</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center g-4 align-items-center">
            <div class="col-lg-4 col-md-6 col-sm-9 col-11 pe-lg-5">
                <div class="market-analysis" data-aos="zoom-in">
                    <img src="{{ displayImage(getArrayValue($fixedContent?->meta, 'blue_theme_main_image'), '418x542') }}" alt="{{ __('market-analysis') }}">
                </div>
            </div>
            <div class="col-lg-8 ps-lg-5">
                <div class="row g-4 analytic-card-wrapper">
                    <div class="analytic-wrapper">
                        @foreach($enhancementContents as $key => $enhancementContent)
                            <div class="analytic-card">
                                <span class="analytic-icon">
                                     @php echo  getArrayValue($enhancementContent->meta, 'icon') @endphp
                                </span>

                                <div class="analytic-content">
                                    <h5>{{ __(getArrayValue($enhancementContent->meta, 'title')) }}</h5>
                                    <p>{{ __(getArrayValue($enhancementContent->meta, 'details')) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
