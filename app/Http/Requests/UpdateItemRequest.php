<?php

namespace App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth ::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $item = $this->route('item');
        return [
            'name' => 'required'|'string'|'min:4'|'max:255',
             Rule::unique('item','name')->ignore($item),
            'description' => 'required'|'string',
            'rental_price' => 'required'|'numeric'|'min:0'|'max:99999.99',
            'stock' => 'required'|'integer'|'min:0',
        ];
    }
}
