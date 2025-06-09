<?php

namespace App\Http\Controllers;

use App\Http\ResponseInterface\ApiResponse;
use App\Http\ResponseInterface\StatusCode;
use App\Models\User;
use Illuminate\Http\Request;

class AssignUserRole extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            /**@var User */
            $user = $request->attributes->get('user');
            $roleId = $request->input('roleId');
            $user->addRoles($roleId);
            $user->save();
            return ApiResponse::success('Role assigned to user successfully', StatusCode::CREATED);
        } catch (\Throwable $e) {
            return ApiResponse::error('Error creating role', $e->getMessage(), StatusCode::BAD_REQUEST);
        }
    }
}
