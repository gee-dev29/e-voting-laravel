<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRoleRequest;
use App\Http\ResponseInterface\ApiResponse;
use App\Http\ResponseInterface\StatusCode;
use App\Models\Role;
use Illuminate\Support\Facades\Log;

class CreateRole extends Controller
{
    public function __invoke(CreateRoleRequest $request)
    {
        try {
            $post = $request->all();
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
