<?php

namespace App\Http\Requests\Api\Authentication;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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

            'name' => 'required|max:100',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|unique:users,phone',
            'password' => 'required|confirmed|max:60',

        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'name.string' => 'Name must be string',
            'name.max' => 'Name cant be more than 100 char',

            'email.required' => 'Email is required',
            'email.email' => 'Email must be valid',
            'email.unique' => 'Email is already used',

            'phone.required' => 'Phone is required',
            'phone.numeric' => 'Phone must be a nubmer',
            'phone.unique' => 'Phone is already used',

            'password.required' => 'Password is required',
            'password.confirmed' => 'Password does not match',
            'password.max' => 'Password cant be more than 60 char',
        ];
    }
}
