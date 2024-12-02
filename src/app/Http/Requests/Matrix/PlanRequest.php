<?php

namespace App\Http\Requests\Matrix;

use Illuminate\Foundation\Http\FormRequest;

class PlanRequest extends FormRequest
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
            'name' => ['required'],
            'amount' => ['required','numeric', 'gt:0'],
            'referral_reward' =>  ['required','numeric', 'gt:0'],
            'status' => ['required','in:1,2'],
            'matrix_levels' => ['required', 'array'],
            'matrix_levels.*' => ['numeric','gt:0']
        ];
    }
}
