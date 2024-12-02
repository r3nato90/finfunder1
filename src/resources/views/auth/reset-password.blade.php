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
                            <h4 class="form-title">{{ __(' Reset Your Password') }}</h4>
                            <form method="POST" action="{{ route('password.store') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-inner">
                                            <label for="email">{{ __('Email') }}</label>
                                            <input type="email" id="email" name="email" class="block" value="{{ old('email', $request->email) }}" autofocus placeholder="{{ __('Enter Email') }}" required>
                                        </div>

                                        <div class="form-inner">
                                            <label for="password">{{ __('Password') }}</label>
                                            <input type="password" id="password" name="password" autocomplete="current-password" placeholder="{{ __('Enter Password') }}" required>
                                        </div>

                                        <div class="form-inner">
                                            <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                                            <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="current-password" placeholder="{{ __('Enter your confirm password') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button class="i-btn btn--lg btn--primary w-100" type="submit">{{ __('Reset Password') }}</button>
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
