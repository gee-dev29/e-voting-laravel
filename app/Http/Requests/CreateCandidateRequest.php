<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCandidateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

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
            'age' => [
                'required',
                'integer',
                'min:2',
                'max:2'
            ],
            'citizenship' => [
                'required',
                'string'
            ],
            'residency' => [
                'required',
                'min:2',
                'string'
            ],
            'votingParty' => [
                'required',
                'string'
            ],
            'town' => [
                'required',
                'string'
            ],
            'lga' => [
                'required',
                'string'
            ],
            'stateOfOrigin' => [
                'required',
                'string'
            ],
            'birthPlace' => [
                'required',
                'string'
            ],
            'nationaliy' => [
                'required',
                'string'
            ],
            'roleId' => ['required', 'string'],
            'roleId.*' => ['uuid'],
            // 'password' => [
            //     'required',
            //     'max:255',
            //     'string',
            //     'confirmed',
            //     \Illuminate\Validation\Rules\Password::min(8)
            //         ->mixedCase()
            //         ->numbers()
            //         ->symbols()
            // ],

        ];
    }

    public function messages()
    {
        return [
            'firstName.string' => "first name must be a string",
            'lastName.string' => "last name must be a string",
            'email.email' => "email must be an email format",
            'age.int' => "Age must be a integer",
            'residency.string' => "Residency must be a string",
            'town.string' => "Town must be a string",
            'lga.string' => "LGA must be a string",
            'stateOfOrigin.string' => "State of origin must be a string",
            'town.string' => "Town must be a string",
        ];
    }
}
