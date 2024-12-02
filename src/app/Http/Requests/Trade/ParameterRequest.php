<?php

namespace App\Http\Requests\Trade;

use App\Enums\Trade\TradeParameterStatus;
use App\Enums\Trade\TradeParameterUnit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ParameterRequest extends FormRequest
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
            'time' => ['required','integer'],
            'unit' => ['required',Rule::in(TradeParameterUnit::values())],
            'status' => ['required',Rule::in(TradeParameterStatus::values())]
        ];
    }
}
