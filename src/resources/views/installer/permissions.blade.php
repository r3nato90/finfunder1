@extends('installer.layouts.master')
@section('content')
    <div class="installer-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-11">
                    @include('installer.partials.top-bar')
                    <div class="installer-wrapper bg--light">
                        <div class="i-card-md">
                            <div class="row g-3">
                                <div class="col-lg-12">
                                    <div class="list-header">
                                        <h6>Permissions</h6>
                                    </div>
                                    <ul class="permission-list">
                                        @foreach($permissions as $key => $permission)
                                            <li class="list {{ $permission['isSet'] ? 'list-success' : 'list-error' }}">
                                                <div>
                                                    <h6>{{ $permission['folder'] }}</h6>
                                                </div>
                                                <p class="{{ $permission['isSet'] ? '' : 'text-danger' }}">
                                                <i class="{{ $permission['isSet'] ? 'bi bi-check-circle-fill i-success' : 'bi bi-exclamation-circle-fill i-danger' }}"></i> {{ $permission['permission'] }}</p>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <div class="text-end">
                            <a href="{{ route('installer.environment') }}"  class="ai--btn i-btn btn--md btn--primary">Next</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
