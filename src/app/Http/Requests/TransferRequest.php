<?php

namespace App\Http\Requests;

use App\Enums\Transaction\WalletType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransferRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'account' => ['required', Rule::in([WalletType::INVESTMENT->value, WalletType::TRADE->value])],
            'amount' => ['required', 'numeric', 'gt:0'],
        ];
    }
}
