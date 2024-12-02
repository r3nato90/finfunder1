<?php

namespace App\Http\Requests;

use App\Enums\GeneralSetting;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GeneralSettingRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', Rule::in(GeneralSetting::values())],
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'The setting type is required.',
            'type.in' => 'Invalid value for the setting type.',
        ];
    }

}
