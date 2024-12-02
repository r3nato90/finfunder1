@php
    $fixedCryptoCoinContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::CRYPTO_COIN, \App\Enums\Frontend\Content::FIXED);
@endphp

@extends('layouts.auth')
@section('content')
    <main>
        <div class="form-section white img-adjust">
            <div class="linear-center"></div>
            <div class="container-fluid px-0">
                <div class="row justify-content-center align-items-center gy-5">
                    <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-8 col-sm-10 position-relative">
                        <div class="eth-icon">
                            <img src="{{ displayImage(getArrayValue($fixedCryptoCoinContent?->meta, 'first_crypto_coin'), "450X450") }}" alt="image">
                        </div>
                        <div class="bnb-icon">
                            <img src="{{ displayImage(getArrayValue($fixedCryptoCoinContent?->meta, 'second_crypto_coin'), "450X450") }}" alt="image">
                        </div>
                        <div class="ada-icon">
                            <img src="{{ displayImage(getArrayValue($fixedCryptoCoinContent?->meta, 'third_crypto_coin'), "450X450") }}" alt="image">
                        </div>
                        <div class="sol-icon">
                            <img src="{{ displayImage(getArrayValue($fixedCryptoCoinContent?->meta, 'fourth_crypto_coin'), "450X450") }}" alt="image">
                        </div>

                        <div class="form-wrapper">
                            <h5 class="form-title">{{ __('Two Factor Authentication') }}</h5>
                            <form method="POST" action="{{ route('two-factor.login') }}">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-inner">
                                            <label for="code">{{ __('Authentication Code') }}</label>
                                            <input type="text" id="code" name="code" placeholder="{{ __('Enter Code') }}" required autofocus>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button class="i-btn btn--lg btn--primary w-100" type="submit">{{ __('Verify') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

