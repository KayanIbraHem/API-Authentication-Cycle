<?php

namespace App\Http\Requests\Dashboard\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductSizeUpdateRequest extends FormRequest
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
            'price' => 'required|numeric'
        ];
    }

    public function messages(): array
    {
        return [
            'price.required'=>'السعر مطلوب',
            'price.numeric'=>'السعر يجب ان يكون رقم',
        ];
    }
}
