<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\CreateUserRequest;
use App\Models\Role;
use Exception;
use Illuminate\Support\Facades\DB;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Http\ResponseInterface\ApiResponse;
use App\Http\ResponseInterface\StatusCode;

class RoleController extends Controller
{
    public function createRole(ServerRequestInterface $req, CreateUserRequest $request)
    {
        try {
            $post = $req->getParsedBody();
            $validator = $request->validated();
            $role = new Role($validator);
            $role->save();
            return ApiResponse::success('Role created successfully', StatusCode::CREATED);
        } catch (\Throwable $th) {
            return ApiResponse::error('Error creating role', $th->getMessage(), StatusCode::BAD_REQUEST);
        }
    }

    public function getRole(CreateRoleRequest $request)
    {
        try {
            $roleId = $request->route('roleId');
            $role = Role::find($roleId);
            return ApiResponse::data($role ?? []);
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    public function deleteRole(CreateRoleRequest $request)
    {
        try {
            $roleId = $request->route('roleId');
            $role = DB::table('role')->where('id', $roleId)->delete();
            if (!$role) {
                return ApiResponse::error('Could not delete candidate', 'Role not found', StatusCode::NOT_FOUND);
            }
            return ApiResponse::noContent();
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

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

    public function getRoles()
    {
        try {
            $role = Role::all();
            $totalRecord = Role::count();
            return ApiResponse::data([
                'totalRecord' => $totalRecord,
                'data' => $role
            ]);
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }
}
