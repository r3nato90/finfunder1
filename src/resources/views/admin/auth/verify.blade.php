@extends('admin.layouts.auth')
@section('content')
    <div class="login-content row g-0 justify-content-center">
        <div class="col-xl-5 col-lg-6 order-lg-2 order-1">
            <div class="form-wrapper-one flex-column rounded-4">
                <div class="logo-area text-center mb-40">
                    <img src="{{ displayImage(getArrayValue($setting->logo, 'dark'), "592x89") }}" alt="Site-Logo" border="0">
                    <h4>{{__('The Verification Code')}}</h4>
                </div>
                <form action="{{route('admin.password.verify.update')}}" method="POST">
                    @csrf
                    <div class="form-inner email">
                        <label for="code">{{ __('admin.input.code') }}</label>
                        <input type="text" name="code" placeholder="{{__('admin.placeholder.code')}}" />
                    </div>
                    <button type="submit" class="btn btn--dark btn--lg w-100">{{__('admin.button.submit')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
