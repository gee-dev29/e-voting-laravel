<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRoleRequest;
use App\Http\ResponseInterface\ApiResponse;
use App\Http\ResponseInterface\StatusCode;
use Exception;
use Illuminate\Http\Request;

class updateRole extends Controller
{

    public function updateRole(CreateRoleRequest $request)
    {
        try {
            $roleId = $request->route('roleId');
            $post  = $request->post();
            $validator = $request->validate();
            $role = DB::table('role')->where('id', $roleId)->update(
                $validator['roleName'] = $post
            );
            if (!$role) {
                return ApiResponse::error('Role not found', 'Role not found', StatusCode::NOT_FOUND);
            }
            return ApiResponse::success('Role updated successfully');
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }
}
