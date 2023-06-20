<?php

namespace App\Http\Requests\Api\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required|numeric',
            'size_id' => 'required|numeric',
            'quantity' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'المنتج مطلوب',
            'product_id.numeric' => 'خطأ في المنتج',
            'size_id.required' => 'المقاس مطلوب',
            'size_id.numeric' => 'خطأ في المقاس',
            'quantity.required' => 'الكمية مطلوبة',
            'quantity.numeric' => 'خطأ في الكمية',

        ];
    }
}
