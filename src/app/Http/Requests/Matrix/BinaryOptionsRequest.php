<?php

namespace App\Http\Requests\Matrix;

use App\Enums\BinaryOptionStatus;
use App\Enums\Investment\InvestmentRage;
use App\Rules\MaxLimit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BinaryOptionsRequest extends FormRequest
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
    public function rules(Request $request): array
    {
        return [
            'name' => ['required', 'max:120'],
            'type' => ['required', Rule::in(InvestmentRage::values())],
            'minimum' => ['required_if:type,1', 'numeric', 'gt:0'],
            'maximum' => ['required_if:type,1', 'numeric', new MaxLimit($request->input('minimum'))],
            'amount' => ['required_if:type,2', 'numeric', 'gt:0'],
            'interest_rate' => ['required', 'numeric', 'gt:0'],
            'terms_policy' => ['required'],
            'repeat_time' => ['required_if:interest_return_type,2', 'integer', 'min:1'],
            'status' =>  ['required', 'integer', Rule::in(\App\Enums\Status::values())],
            'interest_type' =>  ['required', Rule::in(\App\Enums\Investment\InterestType::values())],
            'time_id' =>  ['required', Rule::exists('time_tables', 'id')],
            'interest_return_type' =>  ['required', Rule::in(\App\Enums\Investment\ReturnType::values())],
            'recapture_type' =>  ['required_if:interest_return_type,2', Rule::in(\App\Enums\Investment\Recapture::values())],
        ];
    }
}
