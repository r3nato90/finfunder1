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
                                    <h6>Server Requirements</h6>
                                </div>
                                <ul class="permission-list">
                                    <li class="list list-success">
                                        <div>
                                            <h6>PHP {{ $checkPhpVersion['minimum'] }}  or Higher </h6>
                                        </div>
                                        @php echo  $checkPhpVersion['supported'] ? '<i class="bi bi-check-circle-fill i-success"></i>' : ' <i class="bi bi-exclamation-circle-fill i-danger"></i>' @endphp
                                    </li>
                                    @foreach($requirements as $type => $requirement)
                                        @foreach($requirement['php'] as $key =>  $php)
                                            <li class="list {{ $php ? 'list-success' : 'list-error' }}">
                                                <div><h6>{{ ucfirst($key) }}</h6></div>
                                                @php echo  $php ? '<i class="bi bi-check-circle-fill i-success"></i>' : ' <i class="bi bi-exclamation-circle-fill i-danger"></i>' @endphp
                                            </li>
                                        @endforeach 
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <div class="text-end">
                        <a href="{{ route('installer.permissions') }}"  class="ai--btn i-btn btn--md btn--primary">Next</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
