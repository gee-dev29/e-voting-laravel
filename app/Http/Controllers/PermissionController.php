<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePermissionRequest;
use App\Models\Permission;
use Exception;

class PermissionController extends Controller
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

    public function viewPermission()
    {
        $permission = Permission::all();
        $totalRecords = Permission::count();
        // $data = [];
        return response()->json(
            [
                'totalRecords' => $totalRecords,
                'data' => $permission->data()
            ]
        );
    }

    // public function data()
    // {
    //     return [
    //         'id' => $permission['id'],
    //         'permission' => $permission['permissionName'],
    //         'description' => $permission['description'],
    //         'created_at' => $permission['created_at']->format('Y-m-d'),
    //         'updated_at' => $permission['updated_at']->format('Y-m-d')
    //     ];
    // }
}
