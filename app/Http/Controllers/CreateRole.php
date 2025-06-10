<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\ResponseInterface\ApiResponse;
use App\Http\ResponseInterface\StatusCode;
use App\Models\Role;
use Illuminate\Http\Request;

class CreateRole extends Controller
{
    public function __invoke(CreateUserRequest $request)
    {
        try {
            $post = $request->getParsedBody();
            $role = Role::createRole($post);
            $role->save();
            return ApiResponse::success('Role created successfully', StatusCode::CREATED);
        } catch (\Throwable $th) {
            return ApiResponse::error('Error creating role', $th->getMessage(), StatusCode::BAD_REQUEST);
        }
    }
}
