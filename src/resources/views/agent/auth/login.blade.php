@extends('agent.layouts.auth')
@section('content')
    <div class="login-content row g-0 justify-content-center">
        <div class="col-xl-5 col-lg-6 order-lg-2 order-1">
            <div class="form-wrapper-one flex-column rounded-4">
                <div class="logo-area text-center mb-40">
                    <img src="{{ displayImage(getArrayValue($setting->logo, 'dark'), "592x89") }}" alt="Site-Logo" border="0">
                    <h4>{{__('Agent login')}}</h4>
                </div>
                <form action="{{route('agent.login.authenticate')}}" method="POST">
                    @csrf
                    <div class="form-inner email">
                        <label for="login-email">{{ __('admin.input.email') }}</label>
                        <input type="text" id="login-email" name="email" value="{{ env('APP_MODE') == 'demo' ? env('APP_DEMO_ADMIN') : old('email') }}" placeholder="{{__('admin.placeholder.email')}}" />
                    </div>
                    <div class="form-inner password">
                        <label for="login-password">{{ __('admin.input.password') }}</label>
                        <input type="password" name="password" id="login-password" value="{{ env('APP_MODE') == 'demo' ? env('APP_DEMO_ADMIN_PASS') : '' }}" placeholder="{{__('admin.placeholder.password')}}" />
                    </div>
                    <button type="submit" class="btn btn--dark btn--lg w-100">{{__('admin.button.sign_in')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
