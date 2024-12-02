<?php

namespace App\Http\Requests;

use App\Enums\Status;
use App\Rules\MaxLimit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WithdrawRequest extends FormRequest
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
            'currency_name' => ['required', 'max:20'],
            'min_limit' => ['required', 'numeric', 'gt:0'],
            'max_limit' => ['required', 'numeric', new MaxLimit($request->input('min_limit'))],
            'percent_charge' => ['required', 'numeric', 'gt:0'],
            'fixed_charge' => ['required', 'numeric', 'gt:0'],
            'rate' => ['required', 'numeric', 'gt:0'],
            'status' => ['required', 'numeric', Rule::in(Status::values())],
        ];
    }
}
