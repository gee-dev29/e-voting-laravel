<?php

namespace App\Http\Controllers;

use App\Http\Id\PermissionId;
use App\Http\Requests\CreateRolePermissionsRequest;
use App\Http\ResponseInterface\ApiResponse;
use App\Http\ResponseInterface\StatusCode;
use App\Models\Permission;
use App\Models\RolesPermissions;
use Exception;
use Illuminate\Support\Facades\Log;

class AddRolePermissions extends Controller
{
    public function __invoke(CreateRolePermissionsRequest $request)
    {
        try {
            $roleId = $request->attributes->get('role');
            $post = $request->post();
            $validator = $request->validated();
            foreach ($post['permissionIds'] as $permissionIdString) {
                $permissionId = PermissionId::fromString($permissionIdString);
                $permission = Permission::where(['id' => $permissionId]);
                if (!$permission) {
                    throw new Exception("Permission not found", 1);
                }
                $rolePermission = RolesPermissions::AddPermissionsToRole(array_merge($validator, [
                    'roleId' => $roleId,
                    'permissionId' => $permissionId
                ]));
                $rolePermission->save();
                Log::info('Permission(s) added role successfully', ['userId' => $rolePermission->id()]);
                return ApiResponse::success('Permission(s) added role successfully', StatusCode::CREATED);
            }
        } catch (\Throwable $th) {
            Log::error('Error creating user', ['error' => $th->getMessage()]);
            throw ApiResponse::error('Error creating user', $th->getMessage(), StatusCode::BAD_REQUEST);
        }
    }
}
