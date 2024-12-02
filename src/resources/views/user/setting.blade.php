@extends('layouts.user')
@section('content')
<div class="main-content" data-simplebar>
    <h3 class="page-title mb-4">{{ __('Settings') }}</h3>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <div class="i-card-sm">
        <div class="row gy-5">
            <div class="col-xl-2 col-lg-3">
                <div class="nav-style-three nav-sidebar">
                    <ul class="nav nav-tabs d-flex flex-column justify-content-start gap-lg-4 gap-3" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#tab-one" aria-selected="true" role="tab">
                                <i class="bi bi-shield-check"></i>{{ __('Security') }}
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab-two" aria-selected="false" role="tab" tabindex="-1">
                                <i class="bi bi-info-circle"></i>{{ __('General') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-xl-10 col-lg-9 ps-lg-4">
                <div id="myTabContent3" class="tab-content">
                    <div class="tab-pane fade active show" id="tab-one" role="tabpanel">
                        <h5 class="subtitle">{{ __('Security Management') }}</h5>

                        <div class="user-form">
                            @if(Auth::user()->two_factor_confirmed_at || session('two_factor_confirmed'))
                                <form method="POST" action="{{ route('two-factor.disable') }}">
                                    @csrf
                                    @method('DELETE')
                                    <div class="switch-wrapper">
                                        <div class="text">
                                            <h6>{{ __('Two Factor Authentication') }}</h6>
                                            <p>{{ __('Authenticating With Two Factor Authentication') }}</p>
                                        </div>
                                        <div class="button">
                                            <button type="submit" class="i-btn btn--md btn--primary-outline capsuled">@lang('Disable')</button>
                                        </div>
                                    </div>
                                </form>
                            @elseif(Auth::user()->two_factor_secret)
                                <form method="POST" action="{{ route('two-factor.confirm') }}">
                                    @csrf
                                    <div class="switch-wrapper">
                                        @php echo Auth::user()->twoFactorQrCodeSvg() @endphp
                                        <input type="text" id="code" name="code" placeholder="{{ __('Enter code') }}" required>
                                        <button type="submit" class="i-btn btn--md btn--primary-outline capsuled">@lang('Confirm')</button>
                                    </div>
                                </form>
                                @php session(['two_factor_confirmed' => true]) @endphp
                            @else
                                <form method="POST" action="{{ route('two-factor.enable') }}">
                                    @csrf
                                    <div class="switch-wrapper">
                                        <div class="text">
                                            <h6>{{ __('Two Factor Authentication') }}</h6>
                                            <p>{{ __('Authenticating With Two Factor Authentication') }}</p>
                                        </div>
                                        <div class="button">
                                            <button type="submit" class="i-btn btn--md btn--primary-outline capsuled">@lang('Enable')</button>
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </div>

                        <div class="user-form">
                            <h5 class="subtitle mt-4">{{ __("Ensure your account is using a long, random password to stay secure.") }}</h5>
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-inner">
                                            <label for="current_password">{{ __('Current Password') }} <sup class="text-danger">*</sup></label>
                                            <input type="password" id="current_password" name="current_password" placeholder="{{ __('Enter Current Password') }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-inner">
                                            <label for="password">{{ __('New Password') }} <sup class="text-danger">*</sup></label>
                                            <input type="password" id="password" name="password" placeholder="{{ __('Enter New Password') }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-inner">
                                            <label for="password_confirmation">{{ __('Confirm Password') }} <sup class="text-danger">*</sup></label>
                                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="{{ __('Enter Confirm Password') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="i-btn btn--primary btn--lg">{{ __('Save') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-two" role="tabpanel">
                        <h5 class="subtitle">{{ __('Profile Information') }}</h5>
                        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            <div class="user-settings mb-5">
                                <div class="row align-items-center g-4">
                                    <div class="col-lg-4">
                                        <div class="user">
                                            <div class="image">
                                                <div class="image-upload">
                                                    <input type="file" name="image">
                                                </div>
                                                <div class="upload-overlay">
                                                    <h6>{{ __('Upload') }}</h6>
                                                    <i class="bi bi-camera"></i>
                                                </div>
                                                <img src="{{ displayImage(Auth::user()->image) }}" alt="{{ __('Profile image') }}">
                                            </div>
                                            <div class="content">
                                                <h6>{{ Auth::user()->name }}</h6>
                                                <p>{{ __('Email Address:') }} {{ Auth::user()->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8 text-lg-end text-start">
                                        <div class="row row-cols-xl-3 row-cols-lg-2 row-cols-1 g-3">
                                            <div class="col">
                                                <div class="bg--dark p-3 rounded-2 text-start">
                                                    <p class="fs-14 mb-1 ">{{ __('Primary Balance') }}</p>
                                                    <h6 class="mb-0">{{ getCurrencySymbol() }}{{ shortAmount(Auth::user()->wallet->primary_balance) }}</h6>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="bg--dark p-3 rounded-2 text-start">
                                                    <p class="fs-14 mb-1 ">{{ __('Investment Balance') }}</p>
                                                    <h6 class="mb-0">{{ getCurrencySymbol() }}{{ shortAmount(Auth::user()->wallet->investment_balance) }}</h6>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="bg--dark p-3 rounded-2 text-start">
                                                    <p class="fs-14 mb-1 ">{{ __('Trade Balance') }}</p>
                                                    <h6 class="mb-0">{{ getCurrencySymbol() }}{{ shortAmount(Auth::user()->wallet->trade_balance) }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-form">
                                <h5 class="subtitle">{{ __("Update your account's profile information and email address") }}</h5>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="first_name">{{ __('First Name') }} <sup class="text-danger">*</sup></label>
                                            <input type="text" id="first_name" name="first_name" value="{{ Auth::user()->first_name }}" placeholder="{{ __('First Name') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="last_name">{{ __('Last Name') }} <sup class="text-danger">*</sup></label>
                                            <input type="text" id="last_name" name="last_name" value="{{ Auth::user()->last_name }}" placeholder="{{ __('Last Name') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="email">{{ __('Email') }} <sup class="text-danger">*</sup></label>
                                            <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" placeholder="{{ __('Enter Email') }}">
                                        </div>

                                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                            <div>
                                                <p class="small mt-2 text-muted">
                                                    {{ __('Your email address is unverified.') }}
                                                    <button form="send-verification"  class="text-decoration-none text-muted">
                                                        {{ __('Resend verification') }}
                                                    </button>
                                                </p>

                                                @if (session('status') === 'verification-link-sent')
                                                    <p class="mt-2 text-success">
                                                        {{ __('A new verification link has been sent to your email address.') }}
                                                    </p>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="phone">{{ __('Phone') }} <sup class="text-danger">*</sup></label>
                                            <input type="text" id="phone" name="phone" value="{{ Auth::user()->phone }}" placeholder="{{ __('Enter Phone') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-inner">
                                            <label for="address">{{ __('Address') }} </label>
                                            <input type="text" id="address" name="meta[address][address]" value="{{ getArrayValue(Auth::user()->meta, 'address.address') }}"  placeholder="{{ __('Enter address') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="country">{{ __('Country') }}</label>
                                            <select id="country" name="meta[address][country]">
                                                <option value="">{{ __('Select') }}</option>
                                                @foreach(getCountryList() as $key => $country)
                                                    <option value="{{ getArrayValue($country, 'code') }}" {{ getArrayValue(Auth::user()->meta, 'address.country') == getArrayValue($country, 'code') ? 'selected' : '' }}>{{ getArrayValue($country, 'name') }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="city">{{ __('City') }}</label>
                                            <input type="text" id="city" name="meta[address][city]" value="{{ getArrayValue(Auth::user()->meta, 'address.city') }}"  placeholder="{{ __('Enter City') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="postcode">{{ __('Postcode') }}</label>
                                            <input type="text" id="postcode" name="meta[address][postcode]" value="{{ getArrayValue(Auth::user()->meta, 'address.postcode') }}" placeholder="{{ __('Enter Postcode') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="state">{{ __('State') }}</label>
                                            <input type="text" id="state" name="meta[address][state]" value="{{ getArrayValue(Auth::user()->meta, 'address.state') }}" placeholder="{{ __('Enter State') }}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="i-btn btn--primary btn--lg">{{ __('Update') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
