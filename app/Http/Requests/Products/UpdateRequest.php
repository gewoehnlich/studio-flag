<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'title'       => 'required|string|min:1|max:255',
            'description' => 'nullable|string|max:65535',
            'price'       => 'required|numeric|decimal:2|between:0,99999.99',
            'stock'       => 'nullable|integer|min:0|max:9'
        ];
    }
}
