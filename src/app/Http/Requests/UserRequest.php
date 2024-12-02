<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'first_name' => 'required|max:90',
            'last_name' => 'required|max:90',
            'email' => 'required|email|max:90|unique:users,email,'.request()->input('id'),
            'phone' => 'required|max:20|unique:users,phone,'.request()->input('id'),
            'address' => 'sometimes|max:250',
            'city' => 'sometimes|max:100',
            'state' => 'sometimes|max:100',
            'zip' => 'sometimes|max:100',
        ];
    }
}
