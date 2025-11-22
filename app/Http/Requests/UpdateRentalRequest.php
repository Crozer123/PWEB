<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRentalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check(); 
    }

    public function rules(): array
    {
        return [
            'status' => 'required|in:pending,rented,returned,canceled',
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Status tidak boleh kosong.',
            'status.in'       => 'Status tidak valid.',
        ];
    }
}
