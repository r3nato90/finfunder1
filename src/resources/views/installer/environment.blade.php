@extends('installer.layouts.master')
@section('content')
    <div class="installer-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-11">
                    @include('installer.partials.top-bar')
                    <form action="{{ route('installer.environment.save') }}" method="POST">
                        @csrf
                        <div class="installer-wrapper bg--light">
                            <div class="each-slide">
                                <div class="row g-3">
                                    @foreach($environment as $section => $configs)
                                        @foreach($configs as $configKey => $config)
                                            <div class="col-lg-6">
                                                <div class="form-inner">
                                                    <label for="{{ $configKey }}">{{ $section == "database" ? replaceInputTitle(ucfirst($section)) : '' }} {{ replaceInputTitle(ucfirst($configKey)) }}</label>
                                                    <input name="environments[{{ $section }}][{{ $configKey }}]" value="{{ $configKey == 'url' ? url('/') : $config }}" type="text" id="{{ $configKey }}" placeholder="Enter {{ replaceInputTitle($configKey) }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <div class="d-flex gap-2 justify-content-end">
                                <button type="submit" class="ai--btn i-btn btn--md btn--primary">Next</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
