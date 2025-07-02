<?php

namespace App\Http\Controllers;

use App\Http\Trait\RoleTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetUser extends Controller
{
    use RoleTrait;
    public function __invoke(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->attributes->get('user');
        $roleNames = [];
        $userRoles = $this->getUserRole($user->userId());
        foreach ($userRoles as $userRole) {
            $roleNames[] = $userRole['roleName'];
        }
        return new JsonResponse(array_merge($user->data(), [
            "roleName" => implode(',', $roleNames)
        ]));
    }
}
