<?php

namespace App\Http\Requests;

use App\Enums\Payment\GatewayCode;
use App\Enums\Transaction\WalletType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentProcessRequest extends FormRequest
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
            'amount' => ['required', 'numeric', 'gt:0'],
            'wallet' => ['required', Rule::in(WalletType::PRIMARY->value,WalletType::INVESTMENT->value,WalletType::TRADE->value)],
            'code' => ['required', Rule::exists('payment_methods', 'code')],
        ];
    }
}
