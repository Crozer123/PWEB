<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'name'          => 'required|string|min:4|max:255',
            'category_id'   => 'required|exists:categories,id',
            'description'   => 'required|string',
            'rental_price'  => 'required|numeric|min:0|max:99999999.99',
            'stock'         => 'required|integer|min:0',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }
}
