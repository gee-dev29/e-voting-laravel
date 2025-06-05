<?php

namespace App\Http\Controllers;

use App\Http\Trait\RoleTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class getUser extends Controller
{
    use RoleTrait;
    public function getUser(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->attributes->get('user');
        return new JsonResponse(array_merge($user->data(), [
            "roleName" => $this->getRoleName($user->roleId())
        ]));
    }
}
