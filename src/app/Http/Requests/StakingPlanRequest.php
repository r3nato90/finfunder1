<?php

namespace App\Http\Requests;

use App\Rules\MaxLimit;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StakingPlanRequest extends FormRequest
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
            'duration' => ['required', 'integer'],
            'interest_rate' => ['required','numeric', 'gt:0'],
            'minimum_amount' => ['required','numeric', 'gt:0'],
            'maximum_amount'=> ['required','numeric',  new MaxLimit($request->input('minimum_amount'))],
        ];
    }
}
