<?php

namespace App\Http\Requests;

use App\Enums\Referral\ReferralCommissionType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReferralRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'percent' => ['required', 'array', 'min:1'],
            'percent.*' => ['required', 'numeric'],
            'commission_type' => ['required', Rule::in(ReferralCommissionType::values())]
        ];
    }

}
