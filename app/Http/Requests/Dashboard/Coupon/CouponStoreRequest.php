<?php

namespace App\Http\Requests\Dashboard\Coupon;

use Illuminate\Foundation\Http\FormRequest;

class CouponStoreRequest extends FormRequest
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
            'code' => 'required|unique:coupons|max:14|min:6',
            'type' => 'required',
            'value' => 'required|numeric',
            'precent_off' => 'required|numeric',
            'type_of_use' => 'required|numeric',
            'max_uses' => 'required|numeric',
            'max_discount' => 'required|numeric',
            'minimum_of_total' => 'required|numeric',
            'start_date' => 'required|date',
            'expiry_date' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'يجب ادخال الكود',
            'code.unique' => 'الكود موجود بالفعل',
            'code.max' => 'لا يمكن ان يزيد الكود عن 14 حرف او كلمه',
            'code.min' => 'لا يمكن ان يقل الكود عن 6 احرف او كلمه',

            'type.required' => 'يجب تحديد نوع الخصم',

            'value.required' => 'قيمه الخصم مطلوبة',
            'value.numeric' => 'قيمه الخصم يجب ان تكون رقم',

            'precent_off.required' => 'نسبه الخصم  مطلوبة  ',
            'precent_off.numeric' => 'نسبه الخصم يجب ان تكون رقم',

            'type_of_use.required' => 'نوع الاستخدام مطلوب',
            'type_of_use.numeric' => 'نوع الاستخدام يجب ان تكون رقم',

            'max_uses.required' => 'عدد المستخدمين مطلوب',
            'max_uses.numeric' => 'خطأ ف تحديد عدد المستخدمين',

            'max_discount.required' => 'الحد الأقصى للخصم مطلوب',
            'max_discount.numeric' => 'خطأ ف تحديد  الحد الاقصي للخصم ',

            'minimum_of_total.required' => 'الحد الادنى للعربة مطلوب',
            'minimum_of_total.numeric' => 'خطأ ف تحديد  الحد الادني للعربه ',

            'start_date.required' => 'تاريخ البدأ مطلوب',
            'start_date.date' => 'خطأ في تحديد تاريخ البدأ',

            'expiry_date.required' => 'تاريخ الانتهاء مطلوب',
            'expiry_date.date' => 'خطأ في تحديد تاريخ الانتهاء',

        ];
    }
}
