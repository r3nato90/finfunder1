@extends('admin.layouts.main')
@section('panel')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __($setTitle) }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.general.update') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="{{ \App\Enums\GeneralSetting::SECURITY->value }}">
                @foreach($setting->security as $key => $security)
                    <div class="form-wrapper">
                        <div class="row">
                            <h5 class=" mb-2 fs-14">{{ __(replaceInputTitle($key)) }}</h5>
                            @foreach($security as $security_key => $value)
                                <div class="col-lg-6 mb-3">
                                    @if($security_key == 'status')
                                        <label for="status-{{ $key }}-{{ $security_key }}" class="form-label">{{ __($security_key) }} <sup class="text-danger">*</sup></label>
                                        <select class="form-select" id="status-{{ $key }}-{{ $security_key }}" name="security[{{ $key }}][{{ $security_key }}]" required>
                                            @foreach(\App\Enums\Status::toArray() as $status_key => $status)
                                                <option value="{{ $status }}" @if($status == $value) selected @endif>{{ replaceInputTitle($status_key) }}</option>
                                            @endforeach
                                        </select>
                                    @elseif(in_array($security_key, ['frequency', 'period']))
                                        <label for="{{ $security_key }}" class="form-label">{{ __(replaceInputTitle($security_key)) }} <sup class="text-danger">*</sup></label>
                                        <div class="input-group">
                                            <input type="text" name="security[{{ $key }}][{{ $security_key }}]" value="{{ $value }}" class="form-control" id="{{ $security_key }}" required>
                                            <span class="input-group-text">{{ __($security_key == 'frequency' ? 'Seconds' : 'Minutes') }}</span>
                                        </div>
                                    @else
                                        <label for="{{ $security_key }}" class="form-label">{{ __(replaceInputTitle($security_key)) }} <sup class="text-danger">*</sup></label>
                                        <input type="text" name="security[{{ $key }}][{{ $security_key }}]" value="{{ $value }}" class="form-control" id="{{ $security_key }}" required>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                <button class="i-btn btn--primary btn--lg">{{ __('admin.button.save') }}</button>
            </form>
        </div>
    </div>
@endsection


@push('script-push')
    <script>
        "use strict";
        $('.keywords').select2({
            tags: true,
            tokenSeparators: [',']
        });
    </script>
@endpush



