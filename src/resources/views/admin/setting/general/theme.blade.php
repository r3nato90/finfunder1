<div class="card">
    <div class="card-header">
         <h4 class="card-title">{{__('Theme color setting')}}</h4>
    </div>
    <div class="card-body">
        <form action="{{route('admin.general.update')}}" method="POST">
            @csrf
            <input type="hidden" name="type" value="{{ \App\Enums\GeneralSetting::THEME_SETTING->value }}">
                <div class="row g-3">
                    @foreach($setting->theme_setting as $key => $value)
                        <div class="col-lg-6 mb-3">
                            <label for="{{ $key }}" class="form-label">{{ __(replaceInputTitle($key)) }} <sup class="text-danger">*</sup></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <input type='text' class="input-group-text color-picker" value="{{ $value }}"/>
                                </div>
                                <input type="text" class="form-control color-code" name="theme_setting[{{ $key }}]" id="{{ $key }}" value="{{ $value }}"/>
                            </div>
                        </div>
                    @endforeach
                </div>
            <button class="i-btn btn--primary btn--lg"> {{ __('admin.button.save') }}</button>
        </form>
    </div>
</div>

@push('script-push')
    <script>
        "use strict";
        const initColorPicker = (color) => {
            $('.color-picker').spectrum({
                color,
                change: function (color) {
                    $(this).parent().siblings('.color-code').val(color.toHexString().replace(/^#?/, ''));
                }
            });
        };

        const initColorCodeInput = () => {
            $('.color-code').on('input', function () {
                const color_value = $(this).val();
                $(this).parents('.input-group').find('.color-picker').spectrum({
                    color: color_value,
                });
            });
        };

        const color = $(this).data('color');
        initColorPicker(color);
        initColorCodeInput();
    </script>
@endpush
