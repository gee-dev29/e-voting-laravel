<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePermissionRequest;
use App\Models\Permission;
use Illuminate\Http\Request;

class createPermission extends Controller
{
    public function createPermission(CreatePermissionRequest $request)
    {
        try {
            $validator = $request->validated();
            $permission = new Permission($validator);
            $permission->save();
            return response()->json([
                'message' => 'Permission created successfully',
                'permission' => $permission
            ], 201);
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }
}
