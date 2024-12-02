<div class="card">
    <div class="card-header">
        <h4 class="card-title">{{__('Seo Settings')}}</h4>
    </div>
    <div class="card-body">
        <form action="{{route('admin.general.update')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="{{ \App\Enums\GeneralSetting::SEO_SETTING->value }}">
                <div class="row g-3">
                    
                    @foreach($setting->seo_setting as $key => $value)
                        @if($key == 'description')
                            <div class="col-lg-6 mb-3">
                                <label for="{{ $key }}" class="form-label">{{ __($key) }} <sup class="text-danger">*</sup></label>
                                <textarea class="form-control" id="{{ $key }}" name="seo_setting[{{ $key }}]" required> {{ $value }}</textarea>
                            </div>
                        @elseif($key == 'keywords')
                            <div class="col-lg-6 mb-3">
                                <label for="{{ $key }}" class="form-label">{{ __($key) }} <sup class="text-danger">*</sup></label>
                                <select class="form-select keywords" id="{{ $key }}" name="seo_setting[{{ $key }}][]" multiple="multiple" required>
                                    @foreach($value as $data)
                                        <option value="{{$data}}" selected>{{$data}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @elseif($key == 'image')
                            <div class="col-lg-6 mb-3">
                                <label for="{{ $key }}" class="form-label">{{ __(replaceInputTitle($key)) }} <sup class="text-danger">*</sup></label>
                                <input type="file" name="seo_setting[{{ $key }}]"  value="{{ $value}}" class="form-control" id="{{ $key }}">
                                 <small>{{__('File formats supported: jpeg, jpg, png. The image will be resized to 1920 x 1080 pixels')}}.
                                    <a href="{{displayImage($value)}}" target="_blank">{{__('view image')}}</a>
                                </small>
                            </div>
                        @else
                            <div class="col-lg-6 mb-3">
                                <label for="{{ $key }}" class="form-label">{{ __(replaceInputTitle($key)) }} <sup class="text-danger">*</sup></label>
                                <input type="text" name="seo_setting[{{ $key }}]"  value="{{ $value  }}" class="form-control" id="{{ $key }}" required>
                            </div>
                        @endif
                    @endforeach
                </div>
            <button class="i-btn btn--primary btn--lg"> {{ __('admin.button.save') }}</button>
        </form>
    </div>
</div>

@push('script-push')
    <script>
        "use strict";
        $('.keywords').select2({
            tags: true,
            tokenSeparators: [',']
        });
    </script>
@endpush
