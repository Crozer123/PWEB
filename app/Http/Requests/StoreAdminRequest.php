<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'avatar'   => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
