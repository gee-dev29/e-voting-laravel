<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRolePermissionsRequest extends FormRequest
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
            'roleId' =>
            [
                'required',
                'string'
            ],
            'permissionIds' =>
            [
                'required',
                'array'
            ]
        ];
    }

    public function messages()
    {
        return [
            'roleId.string' => "role ID must be a UUID",
            'permissionIds.array' => "Permission IDs must be an array of Permissions"
        ];
    }
}
