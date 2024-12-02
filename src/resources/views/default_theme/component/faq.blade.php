@php
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::FAQ, \App\Enums\Frontend\Content::FIXED);
    $enhancementContents = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::FAQ, \App\Enums\Frontend\Content::ENHANCEMENT);
@endphp

<div class="faq-section position-relative pt-110 pb-110">
    <div class="linear-right"></div>
    <div class="container">
        <div class="row align-items-start gy-5">
            <div class="col-xl-5 text-start pe-lg-5">
                <div class="section-title mb-60">
                    <h2>{{ getArrayValue($fixedContent?->meta, 'heading') }}</h2>
                    <p>{{ getArrayValue($fixedContent?->meta, 'sub_heading') }}</p>
                </div>
                <a href="{{ getArrayValue($fixedContent?->meta, 'btn_url') }}" class="i-btn btn--primary btn--lg capsuled">{{ getArrayValue($fixedContent?->meta, 'btn_name') }}</a>
                <div class="bet-vecotr style-two">
                    <img src="{{ displayImage(getArrayValue($fixedContent?->meta, 'bg_image'), "385x278") }}" alt="{{ __('Vector image') }}">
                </div>
            </div>
            <div class="col-xl-7">
                <div class="faq-wrap style-border">
                    <div class="accordion" id="accordionExample">
                        @foreach($enhancementContents as $key => $enhancementContent)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-{{ $loop->iteration }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $loop->iteration }}" aria-expanded="true" aria-controls="collapse-{{ $loop->iteration }}">
                                        {{ getArrayValue($enhancementContent->meta, 'question') }}
                                    </button>
                                </h2>
                                <div id="collapse-{{ $loop->iteration }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $loop->iteration }}">
                                    <div class="accordion-body">
                                        <p>{{ getArrayValue($enhancementContent->meta, 'answer') }}</p>
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
