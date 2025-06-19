<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRoleRequest;
use App\Http\ResponseInterface\ApiResponse;
use App\Http\ResponseInterface\StatusCode;

class DeleteRole extends Controller
{
    public function __invoke(CreateRoleRequest $request)
    {
        try {
            $role = $request->attributes->get('role');
            $request->delete($role);
            return ApiResponse::success('Role deleted successfully', StatusCode::OK);
        } catch (\Throwable $th) {
            return ApiResponse::error('Error deleting role', $th->getMessage(), StatusCode::BAD_REQUEST);
        }
    }
}
