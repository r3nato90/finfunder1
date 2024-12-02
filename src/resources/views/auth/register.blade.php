@php
    $fixedCryptoCoinContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::CRYPTO_COIN, \App\Enums\Frontend\Content::FIXED);
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::SIGN_UP, \App\Enums\Frontend\Content::FIXED);
@endphp

@extends('layouts.auth')
@section('content')
    <main>
        <div class="form-section white img-adjust">
            <div class="form-bg">
                <img src="{{ displayImage(getArrayValue($fixedContent?->meta, 'background_image'), "1920x1080") }}" alt="{{ __('Background image') }}">
            </div>
            <div class="linear-center"></div>
            <div class="container-fluid px-0">
                <div class="row justify-content-center align-items-center gy-5">
                    <div class="col-xl-6 col-lg-6">
                        <div class="form-left">
                            <a href="{{route('home')}}" class="logo" data-cursor="Home">
                                <img src="{{ displayImage(getArrayValue($setting?->logo, 'white'), "592x89") }}" alt="{{ __("Logo") }}">
                            </a>
                            <h1>{{ getArrayValue($fixedContent?->meta, 'title') }}</h1>
                            <p> {{ getArrayValue($fixedContent?->meta, 'details') }} </p>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-10 position-relative')}}'">
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
                        <div class="form-wrapper2 login-form">
                            <h4 class="form-title">{{ __('Sign Up Your Account') }}</h4>
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                @if (getArrayValue($setting?->recaptcha_setting, 'registration') == \App\Enums\Status::ACTIVE->value)
                                    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                                @endif

                                <div class="row">
                                    @if($referral)
                                        <div class="col-12">
                                            {{ __("frontend.auth.register.referral", ['name' => $referral->full_name]) }}
                                        </div>
                                    @endif

                                    <div class="col-12">
                                        <div class="form-inner">
                                            <label for="name">{{ (__('Name')) }}</label>
                                            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="{{ __('Enter Name') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-inner">
                                            <label for="email">{{ __('Email') }}</label>
                                            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="{{ __('Enter Email') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-inner">
                                            <label for="password">{{ __('Password') }}</label>
                                            <input type="password" id="password" name="password" autocomplete="new-password" placeholder="{{ __('Enter Password') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-inner">
                                            <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                                            <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" placeholder="{{ __('Enter Confirm Password') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" value="Register" class="i-btn btn--lg btn--primary w-100">{{ __('Sign Up') }}</button>
                                    </div>
                                </div>
                                @include('partials.social-auth')
                                <div class="have-account">
                                    <p class="mb-0">{{ __('Already registered?') }} <a href="{{route('login')}}"> {{ __('Sign In') }}</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@if (getArrayValue($setting?->recaptcha_setting, 'registration') == \App\Enums\Status::ACTIVE->value)
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
