@php
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::CRYPTO_PAIRS, \App\Enums\Frontend\Content::FIXED);
@endphp

<div class="conversion-section bg-color pt-110 pb-110">
    <div class="linear-right"></div>
    <div class="container">
        <div class="row justify-content-center g-4">
            <div class="col-lg-7">
                <div class="section-title style-two text-center mb-60">
                    <h2>{{ getArrayValue($fixedContent?->meta, 'heading') }}</h2>
                    <p>{{ getArrayValue($fixedContent?->meta, 'sub_heading') }}</p>
                </div>
            </div>
        </div>
        <div class="row g-3">
            @foreach($cryptoConversions as $key => $conversion)
                @php
                    $pair = explode('/', $conversion->pair)
                @endphp
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="converstion-item">
                        <div class="content">
                            <h5>{{  strtoupper($conversion->symbol) }} <i class="bi bi-arrow-right"></i> {{ strtoupper($pair[1] ?? 'USDT')  }}</h5>
                            <p>1 {{ strtoupper($conversion->symbol) }} = {{ getArrayValue($conversion->meta, 'current_price') }} {{ strtoupper($pair[1] ?? 'USDT')  }}</p>
                        </div>
                        <div class="icons">
                            <img src="{{ $conversion->file }}" alt="{{ __('image') }}">
                            <img src="{{ displayImage(getArrayValue($fixedContent->meta, 'conversion_image'), '276x276') }}" alt="{{ __('image') }}">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
