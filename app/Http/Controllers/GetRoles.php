<?php

namespace App\Http\Controllers;

use App\Http\ResponseInterface\ApiResponse;
use App\Models\Role;
use Exception;

class GetRoles extends Controller
{
    public function __invoke()
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
