<?php

namespace App\Http\Requests;

use App\Enums\Status;
use App\Rules\MaxLimit;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentGatewayRequest extends FormRequest
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
    public function rules(Request $request): array
    {
        return [
            'name' => ['nullable', 'max:255'],
            'currency' => ['required', 'max:20'],
            'percent_charge' => ['required'],
            'minimum' => ['required', 'numeric', 'gt:0'],
            'maximum' => ['required', 'numeric', new MaxLimit($request->input('minimum'))],
            'rate' => ['required', 'gt:0'],
            'details' => ['nullable'],
            'status' => ['required', Rule::in(Status::values())],
            'image' => ['nullable','image', 'mimes:jpg,png,jpeg'],
        ];
    }
}
