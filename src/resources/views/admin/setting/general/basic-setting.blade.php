<div class="card">
    <div class="card-header">
        <h4 class="card-title">{{__($setTitle)}}</h4>
    </div>
    <div class="card-body">
        <form action="{{route('admin.general.update')}}" method="POST">
            @csrf
            <input type="hidden" name="type" value="{{ \App\Enums\GeneralSetting::APPEARANCE->value }}">
                <div class="row g-3">
                    @foreach($setting->appearance as $key => $value)
                        @if($key == 'timezone')
                            <div class="col-lg-6 mb-3">
                                <label for="timezone" class="form-label">{{ __('App Timezone') }}  <sup class="text-danger">*</sup></label>
                                <select class="form-select" id="timezone" name="appearance[timezone]" required>
                                    @foreach($timeLocations as $timeLocation)
                                        <option value="{{ @$timeLocation}}" @if($value == $timeLocation) selected @endif>{{$timeLocation}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="col-lg-6 mb-3">
                                <label for="{{ $key }}" class="form-label">{{ __(replaceInputTitle($key)) }} <sup class="text-danger">*</sup></label>
                                <input type="text" name="appearance[{{ $key }}]"  value="{{ $value  }}" class="form-control" id="{{ $key }}" required>
                            </div>
                        @endif
                    @endforeach
                </div>
            <button class="i-btn btn--primary btn--lg"> {{ __('admin.button.save') }}</button>
        </form>
    </div>
</div>
