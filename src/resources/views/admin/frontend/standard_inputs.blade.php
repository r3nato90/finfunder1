@if($item == \App\Enums\Frontend\InputField::ICON->value)
    <div class="col-md-6">
        <label for="{{ $key }}" class="form-label">{{ __(replaceInputTitle($key)) }} <sup class="text--danger">*</sup></label>
        <input type="text" class="form-control iconpicker icon" autocomplete="off" name="{{ $key }}" value="{{ $content->meta[$key] ?? '' }}" required>
        <small>{{ __('Here are some Bootstrap icons you can use') }}: <a href="https://icons.getbootstrap.com/#icons" target="_blank">{{ __('Bootstrap Icons') }}</a></small>
    </div>
@elseif($item == \App\Enums\Frontend\InputField::TEXT->value)
    <div class="col-md-6">
        <label for="{{ $key }}" class="form-label">{{ __(replaceInputTitle($key)) }} <sup class="text--danger">*</sup></label>
        <input type="text" class="form-control" id="{{ $key }}" name="{{ $key }}" value="{{ $content->meta[$key] ?? '' }}" placeholder="{{ __(replaceInputTitle($key)) }}" required>
    </div>
@endif


@if($item == \App\Enums\Frontend\InputField::TEXTAREA->value)
    <div class="col-md-12">
        <label for="{{ $key }}" class="form-label">{{ __(replaceInputTitle($key)) }} <sup class="text--danger">*</sup></label>
        <textarea class="form-control" id="{{ $key }}" name="{{ $key }}" placeholder="{{ __(replaceInputTitle($key)) }}" required>{{ $content->meta[$key] ?? '' }}</textarea>
    </div>
@elseif($item == \App\Enums\Frontend\InputField::TEXTAREA_EDITOR->value)
    <div class="col-md-12">
        <label for="{{ $key }}" class="form-label">{{ __(replaceInputTitle($key)) }} <sup class="text--danger">*</sup></label>
        <textarea class="summernote" id="{{ $key }}" name="{{ $key }}" required>@php echo $content->meta[$key] ?? '' @endphp</textarea>
    </div>
@endif


@push('script-push')
    <script>
        "use strict";
        $(document).ready(function () {
            $('.summernote').summernote({
                height: 300,
                dialogsInBody: true,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['fullscreen'],
                    ['insert', ['picture', 'link', 'video']],
                ],
                callbacks: {
                    onInit: function() {
                    }
                }
            });
            $(".note-image-input").removeAttr('name');
        });
    </script>
@endpush
