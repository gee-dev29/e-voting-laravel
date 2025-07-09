<?php

namespace App\Http\Controllers;

use App\Http\ResponseInterface\ApiResponse;
use App\Http\ResponseInterface\StatusCode;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AddRolePermissions extends Controller
{
    public function __invoke(Request $request)
    {
        $role = $request->attributes->get('role');
        $validatedData = $request->validate([
            'permissionIds' => 'required|array',
            'permissionIds.*' => 'required|string|uuid'
        ]);
        $incomingPermissionIds = $validatedData['permissionIds'];
        $addedPermissionIds = [];
        foreach ($incomingPermissionIds as $permissionIdString) {
            // $permissionId = PermissionId::fromString($permissionIdString);
            $permission = Permission::where(['id' => $permissionIdString])->exists();
            if (!$permission) {
                return ApiResponse::error("one or more provided permission IDs are invalid: `{$permissionIdString}` not found.", StatusCode::BAD_REQUEST);
            }
            $addedPermissionIds[] = $permissionIdString;
            // get existing permission IDs to avoid duplicates
            $existingPermissionIdString = $role->permissions()->pluck('id')->toArray();
            $permissionsToAttach = array_diff($addedPermissionIds, $existingPermissionIdString);
            if (empty($permissionsToAttach)) {
                return ApiResponse::success('No new permission to add, or all specified permissions are already linked to this role.', statusCode::OK);
            }
            // $existingPermissionIds = DB::table('role_permission')->whereIn('permissionId', $permissionIdString)->pluck('permissionId')->toArray();
            $role->permissions()->attach($addedPermissionIds);
            Log::info('Permission added to role successfully');
            return ApiResponse::success('Permission(s) successfully attached to role', StatusCode::CREATED);
        }
    }
}
