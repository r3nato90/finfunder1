@foreach($item as $key => $file)
    <div class="col-md-6">
        <div>
            <label for="{{ $key }}" class="form-label">{{ __(replaceInputTitle($key)) }}</label>
            <input type="file" class="form-control" id="{{ $key }}" name="images[{{ $key }}]" value="{{ $content->meta[$key] ?? '' }}" placeholder="{{ __(replaceInputTitle($key)) }}">
            <small>{{__('File formats supported: jpeg, jpg, png. The image will be resized to')}} {{$file['size'] ?? ''}} {{__('pixels')}}.
                <a href="{{displayImage(@$content->meta[$key], $file['size'])}}" target="_blank">{{__('view image')}}</a>
            </small>
        </div>
    </div>
@endforeach
