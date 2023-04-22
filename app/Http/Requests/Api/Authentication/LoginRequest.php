<?php

namespace App\Http\Requests\Api\Authentication;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email_or_phone' => 'required',
            'password' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'email_or_phone.required' => 'ID is required',
            'password.required' => 'Password is required',
        ];
    }
}
