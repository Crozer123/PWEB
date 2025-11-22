<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        $userId = $this->user()->id;

        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $userId,
            'avatar'   => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'password' => 'nullable|string|min:8|confirmed', 
        ];
    }
}
