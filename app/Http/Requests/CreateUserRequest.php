<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return true;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstName' => [
                'string',
                'required',
                'min:2',
                'max:15',
            ],
            'lastName' => [
                'required',
                'min:2',
                'max:15',
                'string'
            ],
            'email' => [
                'required',
                'email',
                'min:5',
                'max:255',
                'unique:users,email'
            ],
            'password' => [
                'required',
                'max:255',
                'string',
                'confirmed',
                \Illuminate\Validation\Rules\Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'phone' => [
                'required',
                'min:8',
                'max:25',
                'string'
            ],
            'otp' => [
                'required',
                'integer'
            ],
            'roleId' => ['array' | 'uuid']
        ];
    }

    public function messages()
    {
        return [
            'firstName.string' => "first name must be a string",
            'lastName.string' => "last name must be a string",
            'email.email' => "email must be an email format",
            'phone.string' => "phone must be a string",
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'email address'
        ];
    }
}
