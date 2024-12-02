<tr>
    <td data-label="{{ __('Label') }}">
        <div class="mb-0">
            <input type="text" class="form-control" name="kyc_configuration[{{ $key }}][field_label]" value="{{ getArrayValue($value, 'field_label') }}">
        </div>
    </td>

    <td data-label="{{ __('Type') }}">
        <div class="mb-2">
            <select class="form-control type-dropdown" name="kyc_configuration[{{ $key }}][field_type]">
                @foreach(\App\Enums\Frontend\InputField::cases() as $status)
                    @unless(in_array($status->value, [\App\Enums\Frontend\InputField::FILE->value,\App\Enums\Frontend\InputField::TEXTAREA_EDITOR->value,\App\Enums\Frontend\InputField::CHECKBOX->value,\App\Enums\Frontend\InputField::RADIO->value]) )
                        <option value="{{ $status->value }}" @if($status->value ==  getArrayValue($value, 'field_type')) selected @endif>{{ replaceInputTitle($status->name) }}</option>
                    @endunless
                @endforeach
            </select>
        </div>
        <div class="add-options"></div>
        <div class="optionsFiled">
            @if(is_array(getArrayValue($value, 'options')))
                @foreach(getArrayValue($value, 'options') as $data)
                    <div class="dropdown-option d-flex justify-content-end mb-2">
                        <input type="text" class="form-control rounded-end-0" name="kyc_configuration[{{ $key }}][options][]" value="{{ $data }}">
                        <a href="javascript:void(0)" class="remove-dropdown-option btn btn--danger btn--sm rounded-end rounded-start-0"><i class="bi bi-x-lg"></i></a>
                    </div>
                @endforeach
            @endif
        </div>
    </td>

    <td data-label="{{ __('Required') }}">
        <div class="form-inner mb-0">
            <select class="form-select" name="kyc_configuration[{{ $key }}][is_required]">
                @foreach(\App\Enums\Frontend\RequiredStatus::toArray() as $required_key =>  $status)
                    <option value="{{ $status }}" @if($status ==  getArrayValue($value, 'is_required')) selected @endif>{{ replaceInputTitle($required_key) }}</option>
                @endforeach
            </select>
        </div>
    </td>

    <td data-label="{{ __('Option') }}">
        <a href="javascript:void(0)" class="i-btn btn--sm btn--danger delete-key-setting-option"><i class="las la-trash"></i></a>
    </td>
</tr>
