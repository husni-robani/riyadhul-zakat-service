<?php

namespace App\Http\Requests;

use App\Enum\DonationType;
use App\Enum\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTransactionRequest extends FormRequest
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
            'donors_id' => 'required|integer',
            'donation_type' => [
                'required', Rule::in([DonationType::Fitrah, DonationType::Sodaqah, DonationType::Mal, DonationType::Infaq])
            ],
            'payment_method' => [
                'required', Rule::in([PaymentMethod::Cash, PaymentMethod::Transfer])
            ],
            'total_money' => 'nullable|numeric|between:0,999999999999.99',
            'total_good' => 'nullable|integer'
        ];
    }
}
