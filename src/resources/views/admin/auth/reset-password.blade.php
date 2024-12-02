@extends('admin.layouts.auth')
@section('content')
    <div class="login-content row g-0 justify-content-center">
        <div class="col-xl-5 col-lg-6 order-lg-2 order-1">
            <div class="form-wrapper-one flex-column rounded-4">
                <div class="logo-area text-center mb-40">
                    <img src="{{ displayImage(getArrayValue($setting->logo, 'dark'), "592x89") }}" alt="Site-Logo" border="0">
                    <h4>{{__('The Verification Code')}}</h4>
                </div>
                <form action="{{route('admin.reset.password.update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="uuid" value="{{$token->uuid}}">
                    <input type="hidden" name="email" value="{{$token->email}}">

                    <div class="form-inner">
                        <label for="login-password">{{ __('admin.input.password') }}</label>
                        <input type="password" name="password" class="form-control" id="login-password" placeholder="{{__('admin.placeholder.password')}}" />
                    </div>

                    <div class="form-inner">
                        <label for="password_confirmation">{{ __('admin.input.confirm_password') }}</label>
                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation"  placeholder="{{__('admin.placeholder.confirm_password')}}" required autofocus>
                    </div>

                    <button type="submit" class="btn btn--dark btn--lg w-100">{{__('admin.button.submit')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
