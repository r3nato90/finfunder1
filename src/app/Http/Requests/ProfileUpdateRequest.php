<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'image' => ['nullable','mimes:jpeg,jpg,png,gif','max:10000'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'phone' => ['required', 'max:20',Rule::unique(User::class)->ignore($this->user()->id)],
            'meta.address.address' => ['sometimes', 'max:100'],
            'meta.address.country' => ['sometimes', 'max:20'],
            'meta.address.city' => ['sometimes', 'max:255'],
            'meta.address.postcode' => ['sometimes', 'max:255'],
            'meta.address.state' => ['sometimes', 'max:20'],
        ];
    }
}
