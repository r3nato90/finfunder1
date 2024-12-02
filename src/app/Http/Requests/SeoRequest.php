<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeoRequest extends FormRequest
{
    const REQUIRED_VALIDATE = 'required';
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
            'keyword.*' => self::REQUIRED_VALIDATE,
            'meta_description' => self::REQUIRED_VALIDATE,
            'social_title' => self::REQUIRED_VALIDATE,
            'social_description' => self::REQUIRED_VALIDATE,
            'meta_image' => 'nullable|image|mimes:jpg,png,jpeg',
        ];
    }
}
