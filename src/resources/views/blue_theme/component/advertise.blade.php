@php
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::ADVERTISE, \App\Enums\Frontend\Content::FIXED);
    $enhancementContents = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::ADVERTISE, \App\Enums\Frontend\Content::ENHANCEMENT);
@endphp

<section class="advertise pt-120 pb-120 bg--dark overflow-hidden">
    <div class="container-fluid container-wrapper">
        <div class="row g-xl-5 gx-4 gy-5 align-items-center">
            <div class="col-lg-6 order-xl-0 order-1">
                <div data-aos="fade-right">
                    <img class="rounded-4" src="https://finfunder.kloudinnovation.com/assets/files/advertise-2.jpg" alt="" />
                </div>
            </div>

            <div class="col-lg-6 order-xl-1 order-0">
                <div class="ms-xl-5" data-aos="fade-left">
                    <div class="section-title title-secondary b-0">
                        <h2>{{ getArrayValue($fixedContent?->meta, 'heading') }}</h2>
                        <p>{{ getArrayValue($fixedContent?->meta, 'sub_heading') }}</p>
                    </div>

                    <ul class="mt-4 d-flex flex-column gap-4">
                        @foreach($enhancementContents as $key => $enhancementContent)
                            <li class="d-flex align-items-center gap-3 lh-base fw-normal text-white">
                                <i class="bi bi-check-circle text-primary"></i>{{ getArrayValue($enhancementContent->meta, 'title') }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
