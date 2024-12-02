@extends('admin.layouts.main')
@section('panel')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{__($setTitle)}}</h4>
        </div>
        <div class="card-body">
            <form action="{{route('admin.general.update')}}" method="POST">
                @csrf
                <input type="hidden" name="type" value="{{ \App\Enums\GeneralSetting::SYSTEM_CONFIGURATION->value }}">
                    @foreach($setting->system_configuration as $key => $value)
                        <ul class="list-group">
                            <li class="list-group-item d-flex flex-wrap flex-sm-nowrap gap-3 justify-content-between align-items-center bg--light border-0">
                                <div>
                                    <h6 class="mb-0">{{ (__(replaceInputTitle($key))) }}</h6>
                                    <p>{{ getArrayValue($value, 'title') }}</p>
                                </div>

                                <div>
                                    <label class="custom--switch" for="{{ $key }}">
                                        <input {{ getArrayValue($value, 'value')  == App\Enums\Status::ACTIVE->value ? 'checked' : '' }}
                                        type="checkbox"
                                        name="system_configuration[{{ $key }}][value]"
                                        class="default_status"
                                        id="{{ $key }}"
                                        value="1">
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </li>
                        </ul>
                    @endforeach
                <button class="i-btn btn--primary btn--lg"> {{ __('Submit') }}</button>
            </form>
        </div>
    </div>
@endsection

