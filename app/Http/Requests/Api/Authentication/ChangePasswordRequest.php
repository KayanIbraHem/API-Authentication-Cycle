<?php

namespace App\Http\Requests\Api\Authentication;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'password' => 'required',
            'new_password'=>'required|confirmed|max:60',
        ];
    }
    public function messages(): array
    {
        return [
            'password.required' => 'Password is required',

            'new_password.required' => 'New Password is required',
            'new_password.confirmed' => 'New Password does not match',
            'new_password.max' => 'New Password cant be more than 60 char',
        ];
    }
}
