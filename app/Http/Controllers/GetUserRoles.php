<?php

namespace App\Http\Controllers;

use App\Http\ResponseInterface\ApiResponse;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class GetUserRoles extends Controller
{
    public function __invoke(Request $request)
    {
        $data = [];
        /**@var User */
        $user = $request->attributes->get('user');
        $roleIds = $user?->roleId();
        foreach ($roleIds as $roleId) {
            /**@var Role */
            $role = Role::where(['id' => $roleId])->first();
            $data[] = $role?->data();
        }
        return ApiResponse::data([
            'totalRecord' => count($data),
            'data' => $data
        ]);
    }
}
