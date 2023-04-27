<?php

namespace App\Http\Requests\Dashboard\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
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
            'name' => 'required|string|min:6|max:30|unique:categories,name',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
            'parent_id'=>'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'الاسم مطلوب',
            'name.min' => ' يجب الا يقل الاسم عن 6 احرف',
            'name.max' => 'يجب الا يزيد الاسم عن 20 حرف',
            'name.unique' => 'الاسم موجود بالفعل',

            'image.required' => 'الصورة مطلوبة',
            'image.image' => 'الصورة مطلوبة',
            'image.mimes' => 'هذا الامتداد غير مدعوم',
            'image.max' => 'حجم الصورة كبير',

            'parent_id.required'=>'القسم التابع مطلوب'
        ];

    }
}
