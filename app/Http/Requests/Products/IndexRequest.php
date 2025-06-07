<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class IndexRequest extends FormRequest
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
            'lower_price' => 'nullable|numeric|between:0,99999.99',
            'upper_price' => 'nullable|numeric|between:0,99999.99',
            'limit'       => 'nullable|integer',
            'order_by'    => 'nullable|string|in:asc,desc'
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if (
                    $this->lower_price &&
                    $this->upper_price &&
                    $this->lower_price > $this->upper_price
                ) {
                    $validator->errors()->add(
                        'price_range',
                        'При фильтрации нижняя допустимая цена не может быть больше наибольшей допустимой цены.'
                    );
                }
            }
        ];
    }
}
