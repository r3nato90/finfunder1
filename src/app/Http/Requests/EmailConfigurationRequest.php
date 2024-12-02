<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailConfigurationRequest extends FormRequest
{
    const REQUIRED_VALIDATE = 'required';
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
            'mail_configuration.from_email' => 'required|email|max:90',
            'mail_configuration.from_name' => 'required|max:120',
            'mail_configuration.host' => self::REQUIRED_VALIDATE,
            'mail_configuration.port' => 'required|integer',
            'mail_configuration.encryption' => 'required|in:ssl,tls',
            'mail_configuration.username' => self::REQUIRED_VALIDATE,
            'mail_configuration.password' => self::REQUIRED_VALIDATE,
        ];
    }
}
