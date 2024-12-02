<div class="card">
    <div class="card-header">
        <h4 class="card-title">{{__('Recaptcha Settings')}}</h4>
    </div>
    <div class="card-body">
        <form action="{{route('admin.general.update')}}" method="POST">
            @csrf
            <input type="hidden" name="type" value="{{ \App\Enums\GeneralSetting::RECAPTCHA_SETTING->value }}">
                <div class="form-wrapper">
                    <div class="row g-3">
                        @foreach($setting->recaptcha_setting as $key => $value)
                            @if($key == 'registration' || $key == 'login')
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label" for="{{ $key }}">{{ __('Captcha With') }} {{ __(replaceInputTitle($key)) }} </label>
                                    <select class="form-select" id="{{ $key }}" name="recaptcha_setting[{{ $key }}]" required>
                                        @foreach(\App\Enums\Status::toArray() as $status_key =>  $status)
                                            <option value="{{ $status }}" @if($status == $value) selected @endif>{{ replaceInputTitle($status_key) }}</option>
                                        @endforeach
                                    </select>
                                </div> 
                            @else
                                <div class="col-lg-6 mb-3">
                                    <label for="{{ $key }}" class="form-label">{{ __(replaceInputTitle($key)) }} <sup class="text-danger">*</sup></label>
                                    <input type="text" name="recaptcha_setting[{{ $key }}]"  value="{{ $value  }}" class="form-control" id="{{ $key }}" required>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            <button class="i-btn btn--primary btn--lg"> {{ __('admin.button.save') }}</button>
        </form>
    </div>
</div>
