<?php

namespace App\Http\Controllers;

use App\Http\Middleware\checkPermission;
use App\Http\Middleware\checkRole;
use App\Http\Requests\CreateRolePermissionsRequest;
use App\Models\Permission;
use App\Models\RolesPermissions;
use Exception;
use Illuminate\Http\Request;

class rolePermissionController extends Controller
{
    public function addRolePermisssions(CreateRolePermissionsRequest $request)
    {
        try {
            // retrieve check role from the middleware
            $roleId = $request->get(checkRole::class);
            $post = $request->post();
            foreach ($post['permissionIds'] as $permissionId) {
                $permission = Permission::find($permissionId);
                if (!$permission) {
                    throw new Exception(`$permission, not found`);
                }
                $validator = $request->validated();
                RolesPermissions::create(array_merge($validator, [
                    'roleId' => $roleId,
                    'permissionId' => $permissionId
                ]));
                return response()->json(['message' => 'permission(s) added to role'], 200);
            }
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }
}
