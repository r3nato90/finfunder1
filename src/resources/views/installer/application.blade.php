@extends('installer.layouts.master')
@section('content')
    <div class="installer-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-11">
                    @include('installer.partials.top-bar')
                    <div class="installer-wrapper bg--light account-setup-step">
                        <div class="i-card-md">
                            <form action="{{ route('installer.run') }}" method="POST">
                                @csrf
                                <div class="row g-md-4 g-3 justify-content-center">
                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="name">Name</label>
                                            <input name="name" value="{{old('name')}}" type="text" id="name" placeholder="Enter name">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="username">Username</label>
                                            <input name="username" value="{{old('username')}}" type="text" id="username" placeholder="Enter username">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="email">Email</label>
                                            <input name="email" value="{{old('email')}}" type="email" id="email" placeholder="Enter email">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <label for="password">Password</label>
                                            <input name="password" value="{{old('password')}}"  type="password" id="password" placeholder="Enter password">
                                            <span>We suggest providing a strong password.</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center mt-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button id="submit-btn" type="submit" class="ai--btn i-btn btn--md btn--primary">Next</button>
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

