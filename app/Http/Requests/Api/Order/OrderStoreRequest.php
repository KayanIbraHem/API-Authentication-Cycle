<?php

namespace App\Http\Requests\Api\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
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
            'payment_method' => 'required|max:255',
            'full_name' => 'required|max:255',
            'city' => 'required|max:255',
            'address' => 'required|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'payment_method.required' => 'طريقه الدفع مطلوبة',
            'payment_method.max' => 'خطأ في طريقه الدفع',
            'full_name.required' => 'الاسم مطلوب',
            'full_name.max' => 'الاسم طويل جدا',
            'address.required' => 'العنوان مطلوب',
            'address.max' => 'العنوان طويل جدا',
            'city.required' => 'المدينة مطلوبة',
            'city.max' => 'خطأ في اسم المدينة',
        ];
    }
}
