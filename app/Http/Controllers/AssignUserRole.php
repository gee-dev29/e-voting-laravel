<?php

namespace App\Http\Controllers;

use App\Http\Exception\UserException;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AssignUserRole extends Controller
{
    public function __invoke(CreateUserRequest $request)
    {
        try {
            /**@var User */
            $user = $request->attributes->get('user');
            $roleId = $request->input();
            $user->addRoles($roleId);
        } catch (\Throwable $e) {
            throw UserException::fromThrowable($e);
        }
    }
}
