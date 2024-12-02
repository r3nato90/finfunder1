@extends('installer.layouts.master')
@section('content')
    <div class="installer-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    @include('installer.partials.top-bar')
                    <div class="installer-wrapper bg--light account-setup-step">
                        <div class="i-card-md">
                            <div class="row text-center">
                                <div class="col-lg-4">
                                    <a href="{{ url('admin') }}" class="ai--btn i-btn btn--md btn--primary">Admin Login</a>
                                </div>
                                <div class="col-lg-4">
                                    <a href="{{ url('login') }}" class="ai--btn i-btn btn--md btn--success">User Login</a>
                                </div>
                                <div class="col-lg-4">
                                    <a href="{{ url('/') }}" class="ai--btn i-btn btn--md btn--info">Frontend</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection