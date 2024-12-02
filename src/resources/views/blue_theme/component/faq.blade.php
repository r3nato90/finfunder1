@php
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::FAQ, \App\Enums\Frontend\Content::FIXED);
    $enhancementContents = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::FAQ, \App\Enums\Frontend\Content::ENHANCEMENT);
@endphp
<section class="faqs pt-120 pb-120">
    <div class="container-fluid container-wrapper">
        <div class="faqs-wrapper">
            <div class="row gx-lg-5 gy-5">
                <div class="col-lg-6 pe-lg-5">
                    <div class="section-title text-start">
                        <h2>{{ getArrayValue($fixedContent?->meta, 'heading') }}</h2>
                        <p>{{ getArrayValue($fixedContent?->meta, 'sub_heading') }}</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="accordion-wrapper">
                        <div class="accordion" id="faq-accordion">
                            @foreach($enhancementContents as $key => $enhancementContent)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading-{{ $loop->iteration }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse-{{ $loop->iteration }}" aria-expanded="false" aria-controls="collapse-{{ $loop->iteration }}">
                                            {{ getArrayValue($enhancementContent->meta, 'question') }}
                                        </button>
                                    </h2>
                                    <div id="collapse-{{ $loop->iteration }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $loop->iteration }}">
                                        <div class="accordion-body">
                                            <p>
                                                {{ getArrayValue($enhancementContent->meta, 'answer') }}
                                            </p>
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
</section>
