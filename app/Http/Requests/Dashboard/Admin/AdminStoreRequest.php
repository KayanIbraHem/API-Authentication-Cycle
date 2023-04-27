<?php

namespace App\Http\Requests\Dashboard\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminStoreRequest extends FormRequest
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
            'name' => 'required|min:6|max:20',
            'email' => 'required|email|unique:admins,email',
            'phone' => 'required|numeric|unique:admins,phone',
            'password' => 'required|max:60',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048'
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'الاسم مطلوب',
            'name.min' => ' يجب الا يقل الاسم عن 6 احرف',
            'name.max' => 'يجب الا يزيد الاسم عن 20 حرف',

            'email.required' => 'البريد الالكتروني مطلوب',
            'email.email' => 'الريد الالكتروني غير صحيح',
            'email.unique' => 'البريد الالكتروني مسنخدم بالفعل',

            'phone.required' => 'رقم الهاتف مطلوب',
            'phone.numeric' => 'رقم الهاتف غير صحيح',
            'phone.unique' => 'رقم الهاتف مستخدم بالفعل',

            'password.required' => 'كلمة المرور مطلوبة',
            'password.max' => 'كلمة المرور يجب الا تزيد عن 60 حرف',

            'image.required'=>'الصورة مطلوبة',
            'image.image'=>'الصورة مطلوبة',
            'image.mimes'=>'هذا الامتداد غير مدعوم',
            'image.max'=>'حجم الصورة كبير'
        ];
    }
}
