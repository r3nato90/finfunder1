<div class="card">
    <div class="card-header">
        <h4 class="card-title">{{__('Social Login')}}</h4>
    </div>
    <div class="card-body">
        <form action="{{route('admin.general.update')}}" method="POST">
            @csrf
            <input type="hidden" name="type" value="{{ \App\Enums\GeneralSetting::SOCIAL_LOGIN->value }}">
            @foreach($setting->social_login as $key => $social)
                <h5 class="fs-14 mb-2"> {{ __(replaceInputTitle($key)) }} </h5>

                <div class="form-wrapper">
                    <div class="row g-3">
                        @foreach($social as $social_key =>  $value)
                            @if($social_key == 'status')
                                <div class="col-lg-6 mb-3">
                                    <label for="social-login-{{ $key }}-{{ $social_key }}" class="form-label">{{ __($social_key) }} <sup class="text-danger">*</sup>
                                    </label>

                                    <select class="form-select" id="social-login-{{ $key }}-{{ $social_key }}" name="social_login[{{ $key }}][{{ $social_key }}]" required>
                                        @foreach(\App\Enums\Status::toArray() as $status_key =>  $status)
                                            <option value="{{ $status }}" @if($status == $value) selected @endif>{{ replaceInputTitle($status_key) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div class="col-lg-6 mb-3">
                                    <label for="{{ $key }}-{{ $social_key }}" class="form-label">{{ __(replaceInputTitle($social_key)) }} <sup class="text-danger">*</sup></label>
                                    <input type="text" name="social_login[{{ $key }}][{{ $social_key }}]"  value="{{ $value  }}" class="form-control" id="{{ $key }}-{{ $social_key }}" required>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
            <button class="i-btn btn--primary btn--lg"> {{ __('admin.button.save') }}</button>
        </form>
    </div>
</div>
