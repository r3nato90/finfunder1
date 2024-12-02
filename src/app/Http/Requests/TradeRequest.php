<?php

namespace App\Http\Requests;

use App\Enums\Trade\TradeType;
use App\Enums\Trade\TradeVolume;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TradeRequest extends FormRequest
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
            'amount' => ['required','numeric','gt:0'],
            'type' => ['required', Rule::in(TradeType::values())],
            'volume' => ['required', Rule::in(TradeVolume::values())],
            'parameter_id' => ['required', Rule::exists('trade_parameters', 'id')],
        ];
    }
}
