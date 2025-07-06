<?php

namespace App\Http\Controllers;

use App\Http\Id\PermissionId;
use App\Http\ResponseInterface\ApiResponse;
use App\Http\ResponseInterface\StatusCode;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AddRolePermissions extends Controller
{
    public function __invoke(Request $request)
    {
        // try {
        $role = $request->attributes->get('role');
        $validatedData = $request->validated([
            'permissionIds' => 'required|array',
            'permissionIds.*' => 'required|string|uuid'
        ]);
        $incomingPermissionIds = $validatedData['permissionIds'];
        $addedPermissionIds = [];
        foreach ($incomingPermissionIds as $permissionIdString) {
            $permissionId = PermissionId::fromString($permissionIdString);
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
                $invalidRoleIds = array_diff($incomingPermissionIds, $existingPermissionIds);
                throw ValidationException::withMessages([
                    'roleId' => 'One or more provided role IDs are invalid: ' . implode(', ', $invalidRoleIds),
                ]);
            }
            $role->permissions()->attach($existingPermissionIds);
            Log::info('Permission added to role successfully');
            return ApiResponse::success('Permission(s) added to role successfully', StatusCode::CREATED);
        }
        // } catch (\Throwable $th) {
        //     return ApiResponse::error('Error creating user', StatusCode::BAD_REQUEST);
        // }
    }
}
