<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRoleRequest;
use App\Http\ResponseInterface\ApiResponse;
use App\Models\Role;
use Exception;

class GetRole extends Controller
{
    public function __invoke(CreateRoleRequest $request)
    {
        try {
            $role = $request->attributes->get('role');
            return ApiResponse::data($role ?? []);
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }
}
