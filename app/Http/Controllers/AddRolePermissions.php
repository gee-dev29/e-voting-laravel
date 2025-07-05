<?php

namespace App\Http\Controllers;

use App\Http\Id\PermissionId;
use App\Http\Requests\CreateRolePermissionsRequest;
use App\Http\ResponseInterface\ApiResponse;
use App\Http\ResponseInterface\StatusCode;
use App\Models\Permission;
use App\Models\RolesPermissions;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddRolePermissions extends Controller
{
    public function __invoke(CreateRolePermissionsRequest $request)
    {
        try {
            $roleId = $request->attributes->get('role');
            $validatedData = $request->validated();
            $permissionIds = $validatedData['permissionIds'];
            $addedPermissionIds = [];
            foreach ($permissionIds as $permissionId) {
                $permissionId = PermissionId::fromString($permissionId);
                $addedPermissionIds[] = $permissionId;
                // $permission = Permission::where(['id' => $permissionId->toString()])->first();
                // if (!$permission) {
                //     throw new Exception("Permission not found", 1);
                // }
                // $rolePermission = RolesPermissions::AddPermissionsToRole([
                //     'roleId' => $roleId,
                //     'permissionIds' => $permissionId->toString()
                // ]);
                $existingPermissionIds = DB::table('role_permission')->whereIn('permissionId', $permissionId->toString())->pluck('permissionId')->toArray();
                if (count($existingPermissionIds) !== count($addedPermissionIds)) {
                    # code...
                }
                $addedPermissionIds[] = $permissionIdString;
                Log::info('Permission added to role successfully', [
                    'roleId' => $roleId,
                    'permissionIds' => $permissionIdString
                ]);
            }
            if (empty($addedPermissionIds)) {
                return ApiResponse::error('No valid permissions provided or added.', 'No permissions were processed.', StatusCode::BAD_REQUEST);
            }

            return ApiResponse::success('Permission(s) added to role successfully', StatusCode::CREATED, [
                'added_permissions' => $addedPermissionIds
            ]);
        } catch (\Throwable $th) {
            Log::error('Error creating user', ['error' => $th->getMessage()]);
            throw ApiResponse::error('Error creating user', $th->getMessage(), StatusCode::BAD_REQUEST);
        }
    }
}
