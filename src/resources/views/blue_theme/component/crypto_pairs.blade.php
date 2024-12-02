@php
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::CRYPTO_PAIRS, \App\Enums\Frontend\Content::FIXED);
@endphp

<section class="conversions bg--light pb-120 pt-120">
    <div class="container-fluid container-wrapper">
        <div class="row align-items-center g-xl-5 g-0">
            <div class="col-xl-5">
                <div class="section-title text-start mb-xl-0">
                    <h2>{{ getArrayValue($fixedContent?->meta, 'heading') }}</h2>
                    <p>{{ getArrayValue($fixedContent?->meta, 'sub_heading') }}</p>
                </div>
            </div>

            <div class="col-xl-7">
                <div class="row g-4 ms-xl-5">
                    @foreach($cryptoConversions->take(6) as $key => $conversion)
                        @php
                            $pair = explode('/', $conversion->pair)
                        @endphp
                        <div class="col-sm-6">
                            <div class="conversion-card">
                                <div class="conversion-title">
                                    <span>
                                         <img src="{{ $conversion->file }}" alt="{{ __('image') }}">
                                    </span>
                                    <h5>{{  strtoupper($conversion->symbol) }} <i class="bi bi-arrow-right"></i> {{ strtoupper($pair[1] ?? 'USDT')  }}</h5>
                                </div>
                                <span>1 {{ strtoupper($conversion->symbol) }} = {{ getArrayValue($conversion->meta, 'current_price') }} {{ strtoupper($pair[1] ?? 'USDT')  }}</span>
                                <div class="usdt-icon">
                                    <img src="{{ $conversion->file }}" alt="{{ __('image') }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
