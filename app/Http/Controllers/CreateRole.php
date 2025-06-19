<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\ResponseInterface\ApiResponse;
use App\Http\ResponseInterface\StatusCode;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CreateRole extends Controller
{
    public function __invoke(CreateUserRequest $request)
    {
        try {
            $post = $request->getParsedBody();
            $role = Role::createRole($post);
            $role->save();
            Log::info('User created successfully', ['userId' => $role->id()]);
            return ApiResponse::success('Role created successfully', StatusCode::CREATED);
        } catch (\Throwable $th) {
            Log::error('Error creating user', ['error' => $th->getMessage()]);
            return ApiResponse::error('Error creating role', $th->getMessage(), StatusCode::BAD_REQUEST);
        }
    }
}
