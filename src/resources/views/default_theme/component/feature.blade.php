@php
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::FEATURE, \App\Enums\Frontend\Content::FIXED);
    $enhancementContents = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::FEATURE, \App\Enums\Frontend\Content::ENHANCEMENT);
@endphp

<div class="feature-section bg-color pt-110 pb-110">
    <div class="container">
        <div class="row gy-5">
            <div class="col-xl-5">
                <div class="section-title style-two text-start">
                    <h2>{{ __(getArrayValue($fixedContent?->meta, 'heading')) }}</h2>
                    <p class="mb-4">{{ __(getArrayValue($fixedContent?->meta, 'sub_heading')) }}</p>
                    <a href="{{ getArrayValue($fixedContent?->meta, 'btn_url') }}" class="i-btn btn--primary btn--lg capsuled">{{ __(getArrayValue($fixedContent?->meta, 'btn_name')) }}</a>
                </div>
            </div>
            <div class="col-xl-7">
                <div class="fearure-wrapper">
                    <div class="row row-cols-lg-2 row-cols-md-2 row-cols-1 g-4">
                        @foreach($enhancementContents as $key => $enhancementContent)
                            <div class="col">
                                <div class="feature-single">
                                    <div class="icon">
                                        @php echo  getArrayValue($enhancementContent->meta, 'icon') @endphp
                                    </div>
                                    <div class="content">
                                        <h4>{{ __(getArrayValue($enhancementContent->meta, 'title')) }}</h4>
                                        <p>{{ __(getArrayValue($enhancementContent->meta, 'details')) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
