<?php

namespace App\Http\Requests;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RewardRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:90'],
            'level' => ['required', 'string', 'max:90'],
            'invest' => ['required', 'numeric', 'gt:0'],
            'team_invest' => ['required', 'numeric', 'gt:0'],
            'deposit' => ['required', 'numeric', 'gt:0'],
            'referral_count' => ['required', 'integer', 'min:0'],
            'reward' => ['required', 'numeric', 'gt:0'],
            'status' => ['required', Rule::in(Status::values())],
        ];
    }
}
