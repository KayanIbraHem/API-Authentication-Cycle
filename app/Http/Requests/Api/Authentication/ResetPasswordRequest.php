<?php

namespace App\Http\Requests\Api\Authentication;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email',
            'code' => 'required',
            'password' => 'required|confirmed|max:60',
            // 'password_confirmation'=>'required',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email is required',
            'email.email' => 'Email must be vaild',
            'email.exists' => 'User not found',

            'code.required' => 'Code is required',
            'password.required' => 'Password is required',

            // 'password_confirmation.confirmed' => 'Passwordconfirmation is required',


        ];
    }
}
