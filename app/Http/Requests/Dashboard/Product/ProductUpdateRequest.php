<?php

namespace App\Http\Requests\Dashboard\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'name' => 'required|string|min:1|max:30|unique:products,name,'.$this->id,
            'maincat_id' => 'required',
            'subcat_id' => 'required',
            'subsub_cat' => 'required',
            // 'size_id' => 'required',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
            'description' => 'required|min:1|max:200',

        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'الاسم مطلوب',
            'name.min' => 'يجب الا يقل الاسم عن حرف',
            'name.max' => 'يجب الا يزيد الاسم عن 20 حرف',
            'name.unique' => 'الاسم موجود بالفعل',

            'maincat_id.required' => 'القسم  مطلوب',
            'subcat_id.required' => 'القسم الرئيسي الفرعي مطلوب',
            'subsub_cat.required' => 'القسم الفرعي مطلوب',
            // 'size_id.required' => 'الحجم مطلوب',

            // 'image.required' => 'الصورة مطلوبة',
            // 'image.image' => 'الصورة مطلوبة',
            // 'image.mimes' => 'هذا الامتداد غير مدعوم',
            // 'image.max' => 'حجم الصورة كبير',



            'description.required' => 'الوصف مطلوب',
            'description.min' => 'يجب الا يقل الوصف عن حرف',
            'description.max' => 'يجب الا يزيد الاسم عن 200 حرف',
        ];
    }
}
