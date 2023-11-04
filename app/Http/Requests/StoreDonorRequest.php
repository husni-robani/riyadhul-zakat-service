<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDonorRequest extends FormRequest
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
            'name' => 'required|string',
            'house_number' => 'required|string',
            'total_muzaki' => 'numeric',
            'email' => $this->input('email') !== null ? 'email' : '',
            'phone' => $this->input('phone') !== null ? 'string' : ''
        ];
    }
}
