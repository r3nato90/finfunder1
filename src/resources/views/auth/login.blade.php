@php
    $fixedCryptoCoinContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::CRYPTO_COIN, \App\Enums\Frontend\Content::FIXED);
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::SIGN_IN, \App\Enums\Frontend\Content::FIXED);
@endphp
@extends('layouts.auth')
@section('content')
    <main>
        <div class="form-section white img-adjust">
            <div class="linear-center"></div>
            <div class="form-bg2">
                <img src="{{ displayImage(getArrayValue($fixedContent?->meta, 'background_image'), "1920x1080") }}" alt="{{ __('Background image') }}">
            </div>
            <div class="container-fluid px-0">
                <div class="row justify-content-center align-items-center gy-5">
                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-10 position-relative">
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
                        <div class="form-wrapper2">
                            <h4 class="form-title">{{ getArrayValue($fixedContent?->meta, 'heading') }}</h4>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                @if (getArrayValue($setting?->recaptcha_setting, 'login') == \App\Enums\Status::ACTIVE->value)
                                    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                                @endif

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-inner">
                                            <label for="email">{{ __('Email') }}</label>
                                            <input type="email" name="email" id="email" value="{{ env('APP_MODE') == 'demo' ? env('APP_DEMO_USER') : old('email') }}" placeholder="{{ __('Enter Email') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-inner">
                                            <label for="password">{{ __('Password') }}</label>
                                            <input type="password" id="password" name="password" value="{{ env('APP_MODE') == 'demo' ? env('APP_DEMO_USER_PASS') : '' }}" autocomplete="current-password" placeholder="{{ __('Enter Password') }}" required>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-sm-6">
                                            <div class="form-inner mb-sm-0 mb-3">
                                                <div class="form-group">
                                                    <input type="checkbox" id="remember_me" name="remember">
                                                    <label for="remember_me">{{ __('Remember me') }}</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 text-sm-end text-start d-flex justify-content-sm-end justify-content-start">
                                            @if (Route::has('password.request'))
                                                <div class="forgot-pass">
                                                    <a href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="i-btn btn--lg btn--primary w-100" type="submit">{{ __('Sign In') }}</button>
                                    </div>
                                </div>
                                @include('partials.social-auth')
                                @if (getArrayValue($setting?->system_configuration, 'registration_status.value') == \App\Enums\Status::ACTIVE->value)
                                    <div class="have-account">
                                        <p class="mb-0">{{ __("Don't have an account?") }} <a href="{{route('register')}}">{{ __('Sign Up') }}</a></p>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="form-left">
                            <a  href="{{route('home')}}" class="logo" data-cursor="Home">
                                <img src="{{ displayImage(getArrayValue($setting?->logo, 'white'), "592x89") }}" alt="{{ __('Logo') }}">
                            </a>
                            <h1>{{ getArrayValue($fixedContent?->meta, 'title') }}</h1>
                            <p>{{ getArrayValue($fixedContent?->meta, 'details') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection


@if (getArrayValue($setting?->recaptcha_setting, 'login') == \App\Enums\Status::ACTIVE->value)
    @push('script-file')
        @php echo RecaptchaV3::initJs() @endphp
    @endpush

    @push('script-push')
        <script>
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ getArrayValue($setting?->recaptcha_setting,'key') }}', {action: 'submit'}).then(function(token) {
                    document.getElementById('g-recaptcha-response').value = token;
                });
            });
        </script>
    @endpush
@endif


