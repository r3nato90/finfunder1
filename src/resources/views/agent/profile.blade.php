@extends('agent.layouts.main')
@section('panel')
    <section class="mt-3 rounded_box">
        <div class="container-fluid p-0 mb-3 pb-2">
            <div class="row d-flex align-items-start rounded">
                <div class="col-xxl-3 col-xl-4 col-lg-5 mb-30">
                    <div class="card b-radius-5 overflow-hidden profile-card">
                        <div class="card-body">
                            <div class="d-flex p-2 bg--lite--violet align-items-center mb-3 flex-column gap-2">
                                <div class="avatar avatar--xl">
                                    <img src="{{ displayImage(auth()->guard('agent')->user()->image) }}" alt="{{ auth()->guard('agent')->user()->name }}">
                                </div>
                                <div class="pl-3">
                                    <h5 class="text--light m-0 p-0">{{$agent->name}}</h5>
                                </div>
                            </div>
                            <ul class="list-group gap-1 mb-0">
                                <li class="list-group-item d-flex justify-content-between align-items-center text--dark fw-bold bg--light border-0">
                                    {{ __('Name')}}<span class="fw-normal">{{$agent->name}}</span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center text--dark fw-bold bg--light border-0">
                                    {{ __('Username')}}<span class="fw-normal">{{$agent->username}}</span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center text--dark fw-bold bg--light border-0">
                                    {{ __('Email')}}<span class="fw-normal">{{$agent->email}}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-9 col-xl-8 col-lg-7">
                    <div class="card mb-3">
                        <div class="p-3">
                            <ul class="nav nav-style-two nav-pills mb-1 gap-3 justify-content-center" id="pills-tab" role="tablist">
                                <li class="nav-item flex-grow-1" role="presentation">
                                    <button class=" nav-link w-100 text-center active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Profile Setting</button>
                                </li>
                                <li class="nav-item flex-grow-1" role="presentation">
                                    <button class=" nav-link w-100 text-center" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Password Update</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h4 class="card-title">{{__('Profile Update')}}</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{route('agent.profile.update')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="name" class="form-label">{{ __('Name')}}</label>
                                            <input type="text" class="form-control" id="name" value="{{$agent->name}}" placeholder="{{ __('Enter Name')}}" name="name">
                                        </div>

                                        <div class="mb-3">
                                            <label for="username" class="form-label">{{ __('Username')}}</label>
                                            <input type="text" class="form-control" id="username" value="{{$agent->username}}" name="username">
                                        </div>

                                        <div class="mb-3">
                                            <label for="email" class="form-label">{{ __('Email')}}</label>
                                            <input type="email" class="form-control" id="email" value="{{$agent->email}}" name="email">
                                        </div>

                                        <div class="mb-3">
                                            <label for="image" class="form-label">{{ __('Image')}}</label>
                                            <input type="file" class="form-control" id="image" name="image">
                                        </div>

                                        <button type="submit" class="btn btn--primary btn--md">{{ __('Submit')}}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{__('Password Update')}}</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{route('agent.password.update')}}" method="post" class="needs-validation">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="current_password" class="form-label">@lang('Current Password') <sup class="text-danger">*</sup></label>
                                            <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Enter Current Password" required="">
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">@lang('New Password') <sup class="text-danger">*</sup></label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter New Password" required="">
                                        </div>

                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label">@lang('Confirm Password') <sup class="text-danger">*</sup></label>
                                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Enter Confirm Password" required="">
                                        </div>
                                        <button class="btn btn--primary btn--md">@lang('Save Changes')</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

